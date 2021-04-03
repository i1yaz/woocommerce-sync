<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WooCommerce</title>

    <style>
        .graybox {
            padding: 15px;
            background: #f8f8f8;
            height: 92vh;
        }

        .slice {
            height: 92vh;
            width: 100%;
            transition: all 0.5s;
            background: #f0f0f0;
            overflow: hidden;
        }

        /* .wtHider {
            width: 1400px !important;
        } */

        .graybox.expanded .slice {
            height: 100%;
            width: 100%;
        }
    </style><!-- Ugly Hack due to jsFiddle issue -->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/toaster.min.js') }}"></script>
    <script src="{{ asset('js/handsontable.full.min.js') }}"></script>
    <link type="text/css" rel="stylesheet"
        href="{{ asset('css/handsontable.full.min.css') }}">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('css/toaster.min.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.3/socket.io.js" integrity="sha512-2RDFHqfLZW8IhPRvQYmK9bTLfj/hddxGXQAred2wNZGkrKQkLGj8RCkXfRJPHlDerdHHIzTFaahq4s/P4V6Qig=="
        crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- <div id="example1" class="hot handsontable htRowHeaders htColumnHeaders"></div> -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="graybox">
        <div class="slice">
            <div id="example1" class="hot handsontable htRowHeaders htColumnHeaders"
                style="height: 100%; overflow: hidden; width: 100%;"
                data-originalstyle="height: 100%; overflow: hidden; width: 100%;"></div>
        </div>
    </div>


    <script>
        var hot;
        function handsonTableLoad(url) {

            return new Promise(function (resolve, reject) {
                var request = new XMLHttpRequest();
                request.open('GET', url);
                request.responseType = 'json';
                request.onload = function () {
                    if (request.status === 200) {
                        resolve(request.response);
                    } else {
                        reject(Error('Data didn\'t load successfully; error code:' + request.statusText));
                    }
                };
                request.onerror = function () {
                    reject(Error('There was a network error.'));
                };
                request.send();
            });
        }

        $(document).ready(function () {

            var sliceElem = document.querySelector('.slice');
            var blueboxElem = sliceElem.parentElement;
            var triggerBtn = document.getElementById('expander');
            var container = document.getElementById('example1');

            handsonTableLoad("{!!url('products/fetch')!!}").then(function (response) {
                var header = [
                                "ID",
                                "Name",
                                "Slug",
                                "Permalink",
                                "Date created",
                                "Date created GMT",
                                "Date modified",
                                "Date modified GMT",
                                "Type",
                                "Status",
                                "Featured",
                                "Catalog visibility",
                                // "Description",
                                "Short description",
                                "SKU",
                                "Price",
                                "Regular price",
                                "Sale price",
                                "Date on sale from",
                                "Date on sale from gmt",
                                "Date on sale to",
                                "Date on sale to gmt",
                                "On sale",
                                "Purchasable",
                                "Total sales",
                                "Virtual",
                                "Downloadable",
                                // downloads:"Downloads",//array
                                "Download limit",
                                "Download expiry",
                                "External url",
                                "Button text",
                                "Tax status",
                                "Tax class",
                                "Manage stock",
                                "Stock quantity",
                                "Backorders",
                                "Backorders allowed",
                                "Backordered",
                                "Sold individually",
                                "Weight",
                                // dimensions:"Dimensions",//array
                                "Shipping required",
                                "Shipping taxable",
                                "Shipping class",
                                "Shipping class id",
                                "Reviews allowed",
                                "Average rating",
                                "Rating count",
                                // upsell_ids:"Upsell ids",array
                                // cross_sell_ids:"Cross sell ids",array
                                "Parent id",
                                "Purchase note",
                                // categories:"Categories",array
                                // tags:"Tags",array
                                // images:"Images",array
                                // attributes:"Attributes",array
                                // default_attributes:"Default attributes",array
                                // variations:"Variations",array
                                // grouped_products:"Grouped products",array
                                "Menu order",
                                // price_html:"Price html",html
                                // related_ids:"Related ids",array
                                // meta_data:"Meta data",array
                                "Stock status",
                                "Purchase price",
                                "Supplier id",
                                "Supplier sku",
                                "Atum controlled",
                                "Out stock date",
                                "Out stock threshold",
                                "Inheritable",
                                "Inbound stock",
                                "Stock on hold",
                                "Sold today",
                                "Sales last days",
                                "Reserved stock",
                                "Customer returns",
                                "Warehouse damage",
                                "Lost in post",
                                "Other logs",
                                "Out stock days",
                                "Lost sales",
                                "Has location",
                                "Update date",
                                // atum_locations:"Atum locations",//array
                                "Atum stock status",
                                "Low stock"
                                // brands:"Brands"//array
                                // _links:"Links" //array
                            ];
                var data = JSON.parse(response);
                hot = new Handsontable(container, {
                    data: data,
                    rowHeaders: true,
                    colHeaders: header,
                    width: '100%',
                    height: '100%',
                    rowHeights: 30,
                    colWidths: 100,
                    dropdownMenu: true,
                    filters: true,
                    afterChange: function (changes, event, oldValue, newValue) {
                        if (event === 'edit') {                            
                            var postData;
                            var changed_row = changes[0][0];
                            var rowData = this.getDataAtRow(changed_row);
                            changes.forEach(([row, db_field, oldValue, newValue]) => {
                                postData = {field: db_field,value:newValue}
                            });
                                $.ajax({
                                    type: "post",
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    url: "{!! url('products/update/"+rowData[0]+"') !!}",
                                    data: postData,
                                    dataType: "json",
                                    success: function (response) {
                                        var data = JSON.parse(response)
                                        var arr = Object.keys(data).map((k) => data[k])
                                        var fieldName = postData.field;
                                        var value = arr[0][postData.field];
                                        toastr.success('', 'Data updated');
                                        hot.setDataAtRowProp(changed_row, fieldName, value, 'update_success');
                                        sessionStorage.setItem(rowData[0], changed_row);
                                    },
                                    error:function(e){
                                        toastr.error('', 'Something went wrong please try again!')
                                    }

                            });
                        }
                    },
                    cells : function(row, col, prop) {
                        var cellProperties = {};
                        var data = this.instance.getDataAtRow(row)
                        if (col > 0) {
                            cellProperties.readOnly = false;
                        }
                        else
                        {
                            cellProperties.readOnly = true;
                            sessionStorage.setItem(data[0],row)
                        }

                        return cellProperties;
                    }
                    
                });
                triggerBtn.addEventListener('click', function () {
                    if (triggerBtn.textContent === 'Collapse') {
                        triggerBtn.textContent = 'Expand';
                        blueboxElem.className = blueboxElem.className.replace(' expanded', '');

                    } else {
                        triggerBtn.textContent = 'Collapse';
                        blueboxElem.className += ' expanded'
                    }
                });
                sliceElem.addEventListener('transitionend', function (e) {
                    if (e.propertyName === 'width') {
                        hot.refreshDimensions();
                    }
                });

            }, function (Error) {
                console.log(Error);
            });

            
            const socket = io("https://woo-lara-api.herokuapp.com");
                socket.on("product home", function (request) {
                    console.log(request);
                })
                socket.on("product created", function (request) {
                    console.log(request);
                })
                socket.on("product updated", function (request) {
                    console.log(request);
                    productUpdate(request)
                })
                socket.on("product deleted", function (request) {
                    console.log(request);
                })
            
            function productUpdate(request) {
                if (request.success == true && request.message == 'product-updated') {
                    let payload = request.data;
                    let data = [];
                    Object.entries(payload).map(item => {
                        data[item[0]] = item[1]
                    })
                    var row = sessionStorage.getItem(data['id'])
                    data.forEach(element => {
                        var key = element[0];
                        var value = element[1]
                        hot.setDataAtRowProp(row, key, value, 'update_success');
                        console.log(key,value)
                    });
                    console.log(data,row);
                }
            }
                

                function isJson(str) {
                    try {
                        JSON.parse(str);
                    } catch (e) {
                        return false;
                    }
                    return true;
                }
        });

    </script>
</body>

</html>