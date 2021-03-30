<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
    <script src="{{ asset('js/handsontable.full.min.js') }}"></script>
    <link type="text/css" rel="stylesheet"
        href="{{ asset('css/handsontable.full.min.css') }}">
</head>

<body>
    <!-- <div id="example1" class="hot handsontable htRowHeaders htColumnHeaders"></div> -->


    <div class="graybox">
        <div class="slice">
            <div id="example1" class="hot handsontable htRowHeaders htColumnHeaders"
                style="height: 100%; overflow: hidden; width: 100%;"
                data-originalstyle="height: 100%; overflow: hidden; width: 100%;"></div>
        </div>
    </div>


    <script>

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

            handsonTableLoad('http://woocommerce-laravel.test/products/fetch').then(function (response) {
                var data = JSON.parse(response);
                var hot = new Handsontable(container, {
                    data: data,
                    rowHeaders: true,
                    colHeaders: true,
                    width: '100%',
                    height: '100%',
                    rowHeights: 30,
                    colWidths: 100,
                    afterChange: function (changes, src, oldValue, newValue) {
                        if (src !== 'loadData') {
                            // console.log('Row index: ' + changes[0][0] + oldValue + newValue)
                            var data = this.getDataAtRow(changes[0][0]);
                            console.log(data)
                        }
                    }
                    // afterSelection: function (r, c) {
                    //     var data = this.getDataAtRow(r);
                    //     console.log(data)
                    // }
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
        });






        // var example = document.getElementById('example');
        // var hot = new Handsontable(example, {
        //     data: Handsontable.helper.createSpreadsheetData(50, 50),
        //     rowHeaders: true,
        //     colHeaders: true,
        //     width: '100%',
        //     height: '100%',
        //     rowHeights: 30,
        //     colWidths: 100,
        // });

        // triggerBtn.addEventListener('click', function () {
        //     if (triggerBtn.textContent === 'Collapse') {
        //         triggerBtn.textContent = 'Expand';
        //         blueboxElem.className = blueboxElem.className.replace(' expanded', '');

        //     } else {
        //         triggerBtn.textContent = 'Collapse';
        //         blueboxElem.className += ' expanded'
        //     }
        // });
        // sliceElem.addEventListener('transitionend', function (e) {
        //     if (e.propertyName === 'width') {
        //         hot.refreshDimensions();
        //     }
        // });



    </script>
</body>

</html>