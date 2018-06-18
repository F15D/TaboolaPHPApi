<?php

namespace F15DTaboola\Backstage\Reports;

/**
 * @method day(array $filters = [])
 * @method week(array $filters = [])
 * @method month(array $filters = [])
 * @method pageTypeBreakdown(array $filters = [])
 * @method placementBreakdown(array $filters = [])
 * @method siteBreakdown(array $filters = [])
 * @method countryBreakdown(array $filters = [])
 * @method platformBreakdown(array $filters = [])
 * @method daySitePlacementBreakdown(array $filters = [])
 *
 * Class RecirculationSummary
 * @package F15DTaboola\Backstage\Reports
 */
class RecirculationSummary extends BaseReports implements ReportTypes
{
    protected $mandatoryFilters = [
        'start_date' => '',
        'end_date' => ''
    ];

    protected $optionalFilters = [
        'campaign',
        'platform',
        'country',
        'site',
        'partner_name',
    ];

    protected $dimensions = [
        'day' => [
            'columns' => [
                'date'
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ]
        ],
        'week' => [
            'columns' => [
                'date',
                'date_end_period',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ]
        ],
        'month' => [
            'columns' => [
                'date',
                'date_end_period',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ]
        ],
        'page_type_breakdown' => [
            'columns' => [
                'campaign',
                'campaign_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'platform',
                'country',
                'site',
            ]
        ],
        'placement_breakdown' => [
            'columns' => [
                'platform',
                'platform_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'campaign',
            ]
        ],
        'site_breakdown' => [
            'columns' => [
                'platform',
                'platform_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'campaign',
            ]
        ],
        'country_breakdown' => [
            'columns' => [
                'platform',
                'platform_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'campaign',
            ]
        ],
        'platform_breakdown' => [
            'columns' => [
                'platform',
                'platform_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'campaign',
            ]
        ],
        'day_site_placement_breakdown' => [
            'columns' => [
                'date',
                'campaign',
                'campaign_name',
            ],
            'mandatoryFilters' => [
                'start_date',
                'end_date',
            ],
            'optionalFilters' => [
                'platform',
                'country',
                'site',
            ]
        ],
    ];

    /**
     * @param $name
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    function run($name, $args)
    {
        $uri = 'recirc-summary/dimensions/'.$name;

        $args = $this->checkMandatoryFilters($args[0] ?? []);

        $content = $this->http->get($uri,['query' => $args])->getBody()->getContents();

        return $this->resultTransformer($content);
    }

    /**
     * @param $data
     * @param bool $isJson
     * @return mixed
     */
    function resultTransformer($data, bool $isJson = true)
    {
        if($isJson) {
            $data = json_decode($data,true);
        }

        $data['results'] = collect($data['results']);

        return $data;
    }

}