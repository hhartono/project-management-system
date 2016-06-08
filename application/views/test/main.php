<html>
    <body>
        <input type='button' value="click to print" onclick='javascript:doClientPrint1();'>
    </body>

    <script src="/assets/js/libs/jquery-1.8.3.min.js"></script>
    <script>
        function doClientPrint1() {
            jsWebClientPrint.print('poid=' + 2345);
        }
    </script>
</html>

