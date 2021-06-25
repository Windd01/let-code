@extends('layout.master')

@section('content')

    <div class="title m-b-md">
        Covid 19
    </div>

    <div class="container">
        <div class="card card-default">
            <div class="card-header">
                <form action="{{route('search')}}" method="get">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control" placeholder="name" name="name">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-success">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <p>Tổng : </p>
                        <span id="total-case"></span>
                    </div>
                    <div class="col-3">
                        <p>Đang nhiễm:</p>
                        <span id="current-case"></span>
                    </div>
                    <div class="col-3">
                        <p>Tử vong: </p>
                        <span id="death-case"></span>
                    </div>
                    <div class="col-3">
                        <p>Hồi phục: </p>
                        <span id="recover-case"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <a class="btn btn-primary" href="{{route('history', ['name' => request('name')])}}">Chi tiết lịch sử</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        var countryName = '{{request('name')}}';
        axios.get('https://covid-api.mmediagroup.fr/v1/cases?country=' + countryName)
            .then(function (response) {
                if(response.data) {
                    $('#total-case').append(response.data.All.confirmed);
                    $('#current-case').append(response.data.All.confirmed - response.data.All.deaths - response.data.All.recovered);
                    $('#death-case').append(response.data.All.deaths);
                    $('#recover-case').append(response.data.All.recovered);
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    </script>
@endsection
