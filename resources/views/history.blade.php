@extends('layout.master')

@section('content')

    <div class="title m-b-md">
        Lịch sử 7 ngày gần nhất
    </div>

    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <form action="{{route('history')}}" method="get">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control" placeholder="name" name="name" value="{{request('name')}}">
                        </div>
                        <div class="col-4">
                            <select name="date">
                                <option @if(date('Y-m-d', strtotime('-1 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-1 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-2 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-2 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-3 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-3 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-4 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-4 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-5 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-5 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-6 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-6 days'))}}</option>
                                <option @if(date('Y-m-d', strtotime('-7 days')) == request('date')) selected @endif>{{date('Y-m-d', strtotime('-7 days'))}}</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-success">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <p>Tổng : </p>
                        <span id="total-case"></span>
                    </div>
                    <div class="col-4">
                        <p>Tử vong: </p>
                        <span id="death-case"></span>
                    </div>
                    <div class="col-4">
                        <p>Hồi phục: </p>
                        <span id="recover-case"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <a class="btn btn-primary" href="#">Chi tiết lịch sử</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        function dayAgo() {
            daysAgo = {};
            for(var i=1; i<=7; i++) {
                daysAgo[i] = moment().subtract(i, 'days').format("YYYY-MM-DD")
            }
            return daysAgo
        }

        var countryName = "{{request('name')}}";

        var dates = dayAgo();

        var searchDate = "{{request('date')}}";

        console.log(searchDate);
        if (searchDate === '')
        {
            searchDate = dates[1];
        }
        // deaths

        axios.get('https://covid-api.mmediagroup.fr/v1/history?status=deaths&country=' + countryName)
            .then(function (response) {
                if(response.data) {
                    $('#death-case').append(response.data.All.dates[searchDate]);
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });


        // confirmed
        axios.get('https://covid-api.mmediagroup.fr/v1/history?status=confirmed&country=' + countryName)
            .then(function (response) {
                if(response.data) {
                    $('#total-case').append(response.data.All.dates[searchDate]);
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        // recovered
        axios.get('https://covid-api.mmediagroup.fr/v1/history?status=recovered&country=' + countryName)
            .then(function (response) {
                if(response.data) {
                    $('#recover-case').append(response.data.All.dates[searchDate]);
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        // axios.get('https://covid-api.mmediagroup.fr/v1/cases?country=' + countryName)
        //     .then(function (response) {
        //         if(response.data) {
        //             $('#total-case').append(response.data.All.confirmed);
        //             $('#current-case').append(response.data.All.confirmed - response.data.All.deaths - response.data.All.recovered);
        //             $('#death-case').append(response.data.All.deaths);
        //             $('#recover-case').append(response.data.All.recovered);
        //         }
        //     })
        //     .catch(function (error) {
        //         // handle error
        //         console.log(error);
        //     })
        //     .then(function () {
        //         // always executed
        //     });
    </script>
@endsection
