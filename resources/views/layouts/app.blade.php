<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tax Calculator</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>

        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Tax Calculator</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('home') }}">Home</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('admin') }}">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('calculate-tax') }}">Calculate Tax</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route('register') }}">Register</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ auth()->user()->name }}</a>
                        </li>
                        <li>
                            <form action="{{ Route('logout') }}" class="form-inline my-2 my-lg-0" method="post">
                                @csrf
                                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <div class="justify-center bg-grey-100 dark:bg-grey-900 sm:items-center">
            @yield('content')
        </div>

        <script>
            $(document).ready(function(){
                $(".btn-general-param-value").on('click', function(e){
                    var param_id = $(this).attr('param_id');
                    var option_value_key = "#param_"+param_id;
                    var option_value = $(option_value_key).val();

                    if(option_value != null && option_value != ''){
                        $.ajax({
                            url: "{{ route('admin_add_param_option') }}",
                            data: {"_token": "{{ csrf_token() }}", "param_id": param_id, "option": option_value},
                            type: 'POST',
                            dataType: 'json',
                            success: function(data){
                                alert(data.message);
                                if(data.status == 1){
                                    location.reload();
                                }
                            },
                            error: function(err){
                                console.log('Add OPtion Value Error:', err);
                            }
                        });
                    } else {
                        alert('Enter correct value.');
                    }
                });

                $(".btn-update-deduct-param").on('click', function(e){
                    var param_id = $(this).attr('param_id');
                    var param_name_key = "#param_name_"+param_id;
                    var deduct_amt_key = "#deduct_amt_"+param_id;
                    var param_name = $(param_name_key).val();
                    var deduct_amt = $(deduct_amt_key).val();

                    if(param_id != null && param_id != '' && param_name != null && param_name != '' && deduct_amt != null && deduct_amt != ''){
                        $.ajax({
                            url: "{{ route('admin_update_params') }}",
                            data: {"_token": "{{ csrf_token() }}", "param_id": param_id, "param_name": param_name, "max_deduct_amt": deduct_amt},
                            type: 'POST',
                            dataType: 'json',
                            success: function(data){
                                alert(data.message);
                                if(data.status == 1){
                                    location.reload();
                                }
                            },
                            error: function(err){
                                console.log('admin_update_deduct_param Error:', err);
                            }
                        });
                    } else {
                        alert('Enter correct value.');
                    }
                });
            });
        </script>
    </body>
</html>
