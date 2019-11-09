<?php
    //A helper class for MySQLMon data
    namespace app {
        class MonData {
            public static $monType = array(
                0 => 'None',
                1 => 'Earth',
                2 => 'Wind',
                3 => 'Fire',
                4 => 'Water',
                5 => 'Lightning',
                6 => 'Ice',
                7 => 'Light',
                8 => 'Dark',
                9 => 'Virus'
            );

            public static $monTypeColor = array(
                0 => '#ffffff',
                1 => '#59db5e',
                2 => '#e5e4a7',
                3 => '#9b0407',
                4 => '#0f3a84',
                5 => '#a5a303',
                6 => '#4e8496',
                7 => '#f3ff54',
                8 => '#444444',
                9 => '#B785C6'
            );
        }
    }