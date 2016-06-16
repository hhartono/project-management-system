 <html>
    <head>
    <link rel="stylesheet" href="/assets/css/style.css" media="screen">
    
    </head>
    <body>
         <div class="gantt"></div>
    </body>
<script src="/assets/js/gantt/jquery.min.js"></script>
    <script src="/assets/js/gantt/jquery.fn.gantt.js"></script>
    <script>
        $(function () {
            $(".gantt").gantt({
                source: "/displaytugas/display",
                itemsPerPage: 7,
                months: [
                    "January", "February", "March", 
                    "April", "May", "June", "July", 
                    "August", "September", "October", 
                    "November", "December"],
                dow: ["S", "M", "T", "W", "Th", "F", "Sa"],
                //navigate: 'scroll', 
                scale: 'days', 
                maxScale: 'months', 
                minScale: 'days'
            });
        });
    </script>
    
    
</html>