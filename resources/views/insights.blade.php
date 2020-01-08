@extends('master')

@section('title', 'On-Boarding Insights')

@section('content')

    <div class="row">

        <div class="col-xs-1-12">

            <div id="container"></div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>
        new Vue({
            el: '#container',
            mounted() {
                axios.get('/api/insight')
                    .then(function (response) {
                        console.log(response);
                        let results = response.data;
                        console.log(results);

                        if (results.length > 0) {
                            Highcharts.chart('container', {

                                title: {
                                    text: ""
                                },

                                subtitle: {
                                    text: ""
                                },

                                yAxis: {
                                    title: {
                                        text: 'Number of Users'
                                    }
                                },

                                xAxis: {
                                    title: {
                                        text: 'Account Process'
                                    },
                                    categories: ['Creation', 'Activation', 'Profile Info', 'Interest', ' Experience', 'Freelancer Status', 'Waiting Approval', 'Approval']
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle'
                                },

                                plotOptions: {
                                    series: {
                                        label: {
                                            connectorAllowed: false
                                        },
                                        pointStart: 0
                                    }
                                },

                                series: results,

                                responsive: {
                                    rules: [{
                                        condition: {
                                            maxWidth: 500
                                        },
                                        chartOptions: {
                                            legend: {
                                                layout: 'horizontal',
                                                align: 'center',
                                                verticalAlign: 'bottom'
                                            }
                                        }
                                    }]
                                }

                            });
                        }
                    })
                    .catch(function (error) {
                        // catching the  error
                        console.log(error);
                    })
            }

        });

    </script>

@endsection
