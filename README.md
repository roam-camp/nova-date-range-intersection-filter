## Date Range Filter for Laravel Nova

Nova filter that displays a Date Range Picker instead of a select, and filters for intersections between two date columns and a selected date range.

### Install

Run this command in your nova project:
`composer require gleampt3/nova-date-range-intersection-filter`

### How to use

Just use DateRangeIntersectionFilter class instead of Filter

```php
 public function filters(Request $request)
    {
        return [
            new \GleamPt3\Filters\DateRangeIntersectionFilter('effective_from', "effective_to", 'Created date'),
        ];
    }
```
