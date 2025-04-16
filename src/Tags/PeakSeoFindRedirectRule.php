<?php

namespace Studio1902\PeakSeo\Tags;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Statamic\Tags\Tags;

class PeakSeoFindRedirectRule extends Tags
{
    /**
     * Finds the first matching redirect rule (exact or regex) for the current URI.
     * 
     * If found, returns the rule data array to be used as context for the wrapped content.
     * If not found, returns null, preventing wrapped content from rendering.
     *
     * @return array|null The matched rule data array, or null if no match found.
     */
    public function index(): ?array
    {
        // Get the outer data structure passed via the parameter
        $param_data = $this->params->get('redirect_data');

        // Extract the actual array of redirect rules using data_get for safety.
        $redirects_array = data_get($param_data, 'redirects');

        if (is_null($redirects_array) || (!is_array($redirects_array) && !$redirects_array instanceof Collection)) {
            Log::warning("Peak SEO FindRedirectRule: Could not find valid 'redirects' array within ':redirect_data' parameter.", [
                'parameter_data_type' => gettype($param_data),
                'extracted_data_type' => gettype($redirects_array)
            ]);
            return null;
        }

        // Now work with the correct collection of rules
        $redirectCollection = collect($redirects_array);

        if ($redirectCollection->isEmpty()) {
            return null;
        }

        // Get current URI
        $currentUri = '/' . request()->path();
        $currentUri = rtrim($currentUri, '/');
        if (empty($currentUri)) {
            $currentUri = '/';
        }

        // Filter out rules without url_old just in case
        $redirectCollection = $redirectCollection->filter(fn($rule) => !empty(Arr::get($rule, 'url_old')));

        $matchedRule = null;

        // Pass 1: Find Exact Match
        $matchedRule = $redirectCollection->firstWhere(function ($rule) use ($currentUri) {
            $urlOld = Arr::get($rule, 'url_old');
            if (Str::startsWith($urlOld, '#') && Str::endsWith($urlOld, '#')) {
                return false;
            }
            $oldUrlExact = rtrim($urlOld, '/');
            if (empty($oldUrlExact)) $oldUrlExact = '/';
            return $oldUrlExact === $currentUri;
        });

        // Pass 2: Find Regex Match
        if (!$matchedRule) {
            $matchedRule = $redirectCollection->first(function ($rule) use ($currentUri) {
                $urlOld = Arr::get($rule, 'url_old');
                if (Str::startsWith($urlOld, '#') && Str::endsWith($urlOld, '#')) {
                    $pattern = $urlOld;
                    $matchResult = @preg_match($pattern, $currentUri);
                    if ($matchResult === false) {
                        Log::warning("Peak SEO FindRedirectRule: Invalid regex pattern in provided data.", ['pattern' => $pattern]);
                        return false;
                    }
                    return $matchResult === 1;
                }
                return false;
            });
        }

        // If rule found, ensure response exists and return it
        if ($matchedRule) {
            $responseValue = data_get($matchedRule, 'response.value', data_get($matchedRule, 'response', '301'));
            if (is_object($matchedRule) && method_exists($matchedRule, 'toArray')) {
                $matchedRule = $matchedRule->toArray();
            } elseif (!is_array($matchedRule)) {
                return null;
            }
            $matchedRule['response'] = $responseValue;
            return $matchedRule;
        }

        // No match found
        return null;
    }
}
