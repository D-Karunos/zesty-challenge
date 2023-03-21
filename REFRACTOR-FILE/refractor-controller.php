<?php
$today = date('Y-m-d');

// Get a list of parameters passed into the URL
$eventuri = $_SERVER['REQUEST_URI'];
$eventbreak = explode('?', $eventuri);
$eventParams = explode('&', $eventbreak[1] ?? '');

// clean the search inputs
$events_array = filter_var_array($_GET, FILTER_SANITIZE_STRING);
$eventsArray = is_array($events_array) ? array_filter($events_array) : [];

// Build up list of OPtions for various search form fields
// --------------------------------------------------------

// WHEN Drop Down Field
$when = [
    'thisWeek' => 'This Week',
    'nextWeek' => 'Next Week',
    'thisMonth' => 'This Month',
    'nextMonth' => 'Next Month',
    'full' => 'Full',
];

// Now get all event Categories (except those sub categories above)
$taxonomies = get_terms(
    'event_category',
    [
        'hide_empty' => true
    ]
);

function CheckDateExists($eventsArray)
{
    if (array_key_exists('date', $eventsArray)): ?>
        <?php foreach ($eventsArray as $key => $eventQuery): ?>
            <?php if ($key == 'date'): ?>
                <?= $eventQuery ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= date('d/m/Y') ?>
    <?php endif;
}

// begin Building Search Query
if ($eventsArray): ?>
    <?php foreach ($eventsArray as $key => $eventQuery):
        if ($key == 'date'):

            if (strpos($eventQuery, '%2F')):
                $eventQuery = urldecode($eventQuery);
            endif;
            $eventQuery = str_replace('/', '-', $eventQuery);
            $dateselect = strtotime($eventQuery);
            $selected_date = date('Y-m-d', $dateselect);

            $metaQuery = [
                'relation' => 'OR',
                [
                    'relation' => 'AND',
                    [
                        'key' => 'start_date',
                        'value' => $selected_date,
                        'compare' => '<=',
                        'type' => 'DATE'
                    ],
                    [
                        'key' => 'end_date',
                        'value' => $selected_date,
                        'compare' => '>=',
                        'type' => 'DATE'
                    ]
                ],
                [
                    'relation' => 'AND',
                    [
                        'key' => 'start_date',
                        'value' => $selected_date,
                        'compare' => '=',
                        'type' => 'DATE'
                    ],
                    [
                        'key' => 'end_date',
                        'value' => $selected_date,
                        'compare' => '=',
                        'type' => 'DATE'
                    ]
                ]
            ];
        endif;

        if ($key == 'when'):
            $eventPeriod = $eventQuery;

            switch ($eventPeriod) {
                case 'thisWeek';
                    $eventPeriodAfter = strtotime('now');
                    $eventPeriodBefore = strtotime('Sunday this week');
                    break;
                case 'nextWeek';
                    $eventPeriodAfter = strtotime('Monday next week');
                    $eventPeriodBefore = strtotime('Sunday next week');
                    break;
                case 'thisMonth';
                    $eventPeriodAfter = strtotime('now');
                    $eventPeriodBefore = strtotime('last day of this month');
                    break;
                case 'nextMonth';
                    $eventPeriodAfter = strtotime('first day of next month');
                    $eventPeriodBefore = strtotime('last day of next month');
                    break;
            }

            if ($eventPeriod == 'full'):
                $metaQuery = [
                    'relation' => 'AND',
                    [
                        'key' => 'end_date',
                        'value' => $today,
                        'compare' => '>=',
                        'type' => 'DATE'
                    ]
                ];
            else:
                $eventPeriodAfter = date('Ymd', $eventPeriodAfter);
                $eventPeriodBefore = date('Ymd', $eventPeriodBefore);
            endif;
        endif;

        if ($key == 'where'):
            $eventLocation = $eventQuery;
            $metaQuery = [
                'key' => 'location',
                'value' => $eventLocation,
                'compare' => 'LIKE'
            ];
        endif;

        if ($key == 'type'):
            $cat = $eventQuery;
            $taxQuery = [
                [
                    'taxonomy' => 'event_category',
                    'field' => 'slug',
                    'terms' => $cat
                ]
            ];
        endif;

    endforeach;
else:
    $metaQuery = [
        'relation' => 'AND',
        [
            'key' => 'end_date',
            'value' => $today,
            'compare' => '>=',
            'type' => 'DATE'
        ]
    ];
endif;