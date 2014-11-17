<?php
/**
 * function getRangeSearch()
 * usually used in SugarBean function create_new_list_query()
 * PARAMS:
     * $tableName
     * $nonDbFieldName  ('area')
     * $minPrefix       ('_min' so min db field name is: area_min)
     * $maxPrefix       ('_max' so max db field name is: area_max)
     * $request         ('$_REQUEST')
     * $where
 * RETURN: modified $where
 */
function getRangeSearch ($tableName, $nonDbFieldName = 'area', $minPrefix = 'min', $maxPrefix = 'max', $request, $where)
{

    $searchType = ($request['searchFormTab'] == 'basic_search') ? '_basic' : '_advanced';

    if (isset($request[$nonDbFieldName . $searchType . '_range_choice']))
    {
        $rangeChoice = $request[$nonDbFieldName . $searchType . '_range_choice'];

        if ($rangeChoice == 'between')
        {
            $nonDbFieldMinValue = intval($request["start_range_" . $nonDbFieldName . $searchType]);
            $nonDbFieldMaxValue = intval($request["end_range_" . $nonDbFieldName . $searchType]);

            $replace_str = "$tableName.$nonDbFieldName >= {$nonDbFieldMinValue} AND $tableName.$nonDbFieldName <= {$nonDbFieldMaxValue}";

            $to_replace = " ($tableName." . $nonDbFieldName . "$minPrefix BETWEEN {$nonDbFieldMinValue} AND {$nonDbFieldMaxValue}) OR
                                ($tableName." . $nonDbFieldName . "$maxPrefix BETWEEN {$nonDbFieldMinValue} AND {$nonDbFieldMaxValue}) OR
                                ($tableName." . $nonDbFieldName . "$minPrefix < {$nonDbFieldMinValue} AND $tableName." . $nonDbFieldName . "$maxPrefix > {$nonDbFieldMaxValue})

                              ";
        }
        else {
            $nonDbFieldValue = intval($request["range_" . $nonDbFieldName . $searchType]);

            if ($nonDbFieldValue != 0)
            {
                if ($rangeChoice == 'less_than' || $rangeChoice == 'less_than_equals')
                {
                    $rangeChoice = $rangeChoice == 'less_than' ? '<' : '<=';

                    $to_replace = " $tableName." . $nonDbFieldName . "$minPrefix $rangeChoice $nonDbFieldValue ";
                }

                if ($rangeChoice == 'greater_than' || $rangeChoice == 'greater_than_equals')
                {
                    $rangeChoice = $rangeChoice == 'greater_than' ? '>' : '>=';

                    $to_replace = " $tableName." . $nonDbFieldName . "$maxPrefix $rangeChoice $nonDbFieldValue ";
                }


                if ($rangeChoice == '=' || $rangeChoice == 'not_equal')
                {
                    $rangeChoice = $rangeChoice == '=' ? '=' : '!=';

                    if ($rangeChoice == '=')
                    {
                        $to_replace = " $nonDbFieldValue BETWEEN $tableName." . $nonDbFieldName . "$minPrefix AND $tableName." . $nonDbFieldName . "$maxPrefix ";
                    }

                    if ($rangeChoice == '!=') {
                        $to_replace = " $nonDbFieldValue NOT BETWEEN $tableName." . $nonDbFieldName . "$minPrefix AND $tableName." . $nonDbFieldName . "$maxPrefix ";
                        $rangeChoice = "IS NULL OR $tableName.$nonDbFieldName !=";
                    }
                }
            }

            $replace_str = "$tableName.$nonDbFieldName $rangeChoice $nonDbFieldValue";
        }



        return $to_replace;
    }

    return $where;
}