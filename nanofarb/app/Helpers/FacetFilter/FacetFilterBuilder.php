<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 23.01.19
 * Time: 23:55.
 */

namespace App\Helpers\FacetFilter;

class FacetFilterBuilder
{
    /**
     * See icon https://www.w3schools.com/charsets/ref_utf_symbols.asp.
     *
     * @var string
     */
    public static $filterUrlKey = '⛃';

    protected $attrsDelimiter = '♦';

    protected $valuesDelimiter = '⚬';

    protected $attrValuesDelimiter = '☛';

    protected $urlPath;

    /**
     * @return null|string|string[]
     */
    public function build(?string $attr = null, ?string $value = null): string
    {
        $currentFilter = request(self::$filterUrlKey, '');
        $newFilter = $this->toggle($currentFilter, $attr, $value);

        $persistParameters = request()->except('sort', 'direction', 'page', self::$filterUrlKey);

        if ($newFilter) {
            $queryString = urldecode(http_build_query(array_merge($persistParameters, [
                self::$filterUrlKey => $newFilter,
            ])));

            return url($this->getUrlPath() . '?' . $queryString);
        }

        return url($this->getUrlPath());
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function reset(): string
    {
        $queryString = urldecode(http_build_query(request()->except('sort', 'direction', 'page', self::$filterUrlKey)));

        return rtrim(url($this->getUrlPath() . '?' . $queryString), '?');
    }

    /**
     * @return mixed
     */
    public function getUrlPath(): string
    {
        if ($this->urlPath) {
            return $this->urlPath;
        }

        return request()->path();
    }

    /**
     * @param $urlPath
     *
     * @return \App\Helpers\FacetFilter\FacetFilterBuilder
     */
    public function setUrlPath(string $urlPath): self
    {
        $this->urlPath = $urlPath;

        return $this;
    }

    public function issetFilter(): bool
    {
        return request()->has(self::$filterUrlKey);
    }

    public function has(string $attr, ?string $value = null): bool
    {
        $currentFilter = request(self::$filterUrlKey, '');

        $filterArray = $this->toArray($currentFilter);

        if ($value) {
            return in_array($value, $filterArray[$attr] ?? []);
        }

        return in_array($attr, array_keys($filterArray));
    }

    /**
     * @param string $attr
     * @param string $value
     */
    public function toggle(string $currentFilter, ?string $attr = null, ?string $value = null): string
    {
        if (empty($attr)) {
            return '';
        }

        $filterArray = $this->toArray($currentFilter);

        if (empty($value)) {
            unset($filterArray[$attr]);

            return $this->toStr($filterArray);
        }

        if (isset($filterArray[$attr]) && (($index = array_search($value, $filterArray[$attr])) !== false)) {
            unset($filterArray[$attr][$index]);
            if (!count($filterArray[$attr])) {
                unset($filterArray[$attr]);
            }
        } else {
            $filterArray[$attr][] = $value;
        }

        return $this->toStr($filterArray);
    }

    /**
     * @param string $str
     */
    public function toArray(?string $str = null): array
    {
        $facet = [];
        if (count($filterAttrsValues = explode($this->attrsDelimiter, $str))) {
            foreach ($filterAttrsValues as $row) {
                if (count($res = explode($this->attrValuesDelimiter, $row)) == 2) {
                    if (count($values = explode($this->valuesDelimiter, $res[1]))) {
                        $facet[$res[0]] = $values;
                    }
                }
            }
        }

        return $facet;
    }

    public function toStr(array $array): string
    {
        $str = '';
        foreach ($array as $attr => $values) {
            $str .= $attr . $this->attrValuesDelimiter . implode($this->valuesDelimiter, $values) . $this->attrsDelimiter;
        }

        return trim($str, $this->attrsDelimiter);
    }
}
