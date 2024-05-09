<?php

namespace GleamPt3\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Filters\Filter;

class DateRangeIntersectionFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'nova-date-range-intersection-filter';

    protected string $fromDateColumn;
    protected string $toDateColumn;

    /**
     * Create a new filter instance.
     *
     * @param string $fromDateColumn
     * @param string $toDateColumn
     * @param null $name
     */
    public function __construct(string $fromDateColumn, string $toDateColumn, $name = null)
    {
        $this->fromDateColumn = $fromDateColumn;
        $this->toDateColumn = $toDateColumn;
        $this->name = $name ?? "Date Range";
    }

    /**
     * Apply the filter to the given query.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        $from = Carbon::parse($value[0])->startOfDay();
        if (count($value) == 1) {
            $to = Carbon::parse($value[0])->endOfDay();
        } else {
            $to = Carbon::parse($value[1])->endOfDay();
        }

        return $query->where($this->toDateColumn,'>=', $from)
        ->where($this->fromDateColumn,'<=', $to);
    }

    public function enableTime()
    {
        $this->withMeta(['enableTime' => true]);
        return $this;
    }

    public function dateFormat($format)
    {
        $this->withMeta(['dateFormat' => $format]);
        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->withMeta(['placeholder' => $placeholder]);
        return $this;
    }

    public function options(NovaRequest $request)
    {
        return [
            'firstDayOfWeek' => 1,
            'separator' => '-',
            'enableTime' => false,
            'enableSeconds' => false,
            'twelveHourTime' => false,
            'mode' => 'range'
        ];
    }

    /**
     * Get the key for the filter.
     *
     * @return string
     */
    public function key()
    {
        return 'timestamp_' . $this->fromDateColumn;
    }

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Filter By ') . $this->name;
    }
}
