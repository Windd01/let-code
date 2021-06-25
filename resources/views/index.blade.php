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
                    <div class="col-3">Tổng : <span id="total-case"></span></div>
                    <div class="col-3">Đang nhiễm: <span id="current-case"></span></div>
                    <div class="col-3">Tử vong: <span id="death-case"></span></div>
                    <div class="col-3">Hồi phục: <span id="recover-case"></span></div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Country Name</th>
                        <th scope="col">Total case</th>
                        <th scope="col">Current case</th>
                        <th scope="col">Death</th>
                        <th scope="col">Recover</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        let url = '{{route('index')}}';
        axios.get('https://covid-api.mmediagroup.fr/v1/cases')
            .then(function (response) {
                for (var key in response.data) {
                    let html = "<tr><td><a href='"+ url +"/tim-kiem?name=" + key +"'>"+ key +"</td></a>\n" +
                        "            <td>"+ response.data[key].All.confirmed +"</td>\n" +
                        "            <td>"+ (response.data[key].All.confirmed - response.data[key].All.deaths - response.data[key].All.recovered)+"</td>\n" +
                        "            <td>"+ response.data[key].All.deaths +"</td>\n" +
                        "            <td>"+ response.data[key].All.recovered +"</td></tr>"
                    $('#table-body').append(html)
                }
                // handle success
                console.log(response.data);

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
