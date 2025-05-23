<!--
	THIS EXAMPLE WAS DOWNLOADED FROM https://echarts.apache.org/examples/en/editor.html?c=line-race
-->
<!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <meta charset="utf-8">
</head>
<body style="height: 100%; margin: 0">
<div id="container" style="height: 100%"></div>

<script type="text/javascript" src="https://echarts.apache.org/en/js/vendors/jquery@3.7.1/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

<!-- Uncomment this line if you want to dataTool extension
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5/dist/extension/dataTool.min.js"></script>
-->
<!-- Uncomment this line if you want to use gl extension
<script type="text/javascript" src="https://echarts.apache.org/en/js/vendors/echarts-gl/dist/echarts-gl.min.js"></script>
-->
<!-- Uncomment this line if you want to echarts-stat extension
<script type="text/javascript" src="https://echarts.apache.org/en/js/vendors/echarts-stat/dist/ecStat.min.js"></script>
-->
<!-- Uncomment this line if you want to echarts-graph-modularity extension
<script type="text/javascript" src="https://echarts.apache.org/en/js/vendors/echarts-graph-modularity/dist/echarts-graph-modularity.min.js"></script>
-->
<!-- Uncomment this line if you want to use map
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@4.9.0/map/js/world.js"></script>
-->
<!-- Uncomment these two lines if you want to use bmap extension
<script type="text/javascript" src="https://api.map.baidu.com/api?v=3.0&ak=YOUR_API_KEY"></script>
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5/dist/extension/bmap.min.js"></script>
-->

<script type="text/javascript">
    var dom = document.getElementById('container');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });
    var app = {};
    //var ROOT_PATH = 'https://echarts.apache.org/examples';
    var ROOT_PATH = window.location.origin;
    var option;

    $.get(
        // ROOT_PATH + '/data/asset/data/life-expectancy-table.json',
        // ROOT_PATH + '/life-expectancy-table.json',
        // ROOT_PATH + '/convertcsv.json',
        ROOT_PATH + '/rrc_real_estate_data_sorted_rounded.json',
        function (_rawData) {
            run(_rawData);
        }
    );

    function run(_rawData) {
        // var countries = ['Australia', 'Canada', 'China', 'Cuba', 'Finland', 'France', 'Germany', 'Iceland', 'India', 'Japan', 'North Korea', 'South Korea', 'New Zealand', 'Norway', 'Poland', 'Russia', 'Turkey', 'United Kingdom', 'United States'];
        const countries = [
            'Market value of real estate',
            'RRC market capitalization',
        ];
        const datasetWithFilters = [];
        const seriesList = [];
        echarts.util.each(countries, function (country) {
            var datasetId = 'dataset_' + country;
            datasetWithFilters.push({
                id: datasetId,
                fromDatasetId: 'dataset_raw',
                transform: {
                    type: 'filter',
                    config: {
                        and: [
                            {dimension: 'Year', gte: 0},
                            {dimension: 'Country', '=': country}
                        ]
                    }
                }
            });
            seriesList.push({
                type: 'line',
                datasetId: datasetId,
                showSymbol: false,
                name: country,
                endLabel: {
                    show: false,
                    formatter: function (params) {
                        //return params.value[3] + ': ' + params.value[0];
                        return params.value[2];
                    }
                },
                labelLayout: {
                    moveOverlap: 'shiftY'
                },
                emphasis: {
                    focus: 'series'
                },
                encode: {
                    x: 'Year',
                    y: 'Income',
                    label: ['Country', 'Income'],
                    itemName: 'Year',
                    tooltip: ['Income']
                }
            });
        });
        option = {
            animationDuration: 5000,
            color: ['#1e9dff', '#fa6c3a'],
            dataset: [
                {
                    id: 'dataset_raw',
                    source: _rawData
                },
                ...datasetWithFilters
            ],
            // title: {
            //   text: 'Здесь заголовок для графика'
            // },
            // tooltip: {
            //   order: 'valueDesc',
            //   trigger: 'axis'
            // },
            xAxis: {
                type: 'category',
                nameLocation: 'middle',
                name: 'Ось OX',
                show: false,
            },
            yAxis: {
                name: 'Ось OY',
                show: false,
            },
            grid: {
                right: 0,
                left: 0,
                top: 0,
                bottom: 0,
            },
            tooltip: {show: false},
             legend: {show: false},
            series: seriesList
        };
        myChart.setOption(option);
    }

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
</body>
</html>