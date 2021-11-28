<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Premier League Simulator</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
</head>
<body>
<div id="start" class="row mt-5 text-center">
    <div class="col-md-4 offset-md-4">
        <h1 class="display-5">Choose the quantity of teams</h1>
        <h1 id="team_count" class="display-3 text-primary">4</h1>
        <div class="row">
            <div class="col-md-1 text-primary">
                <h1>4</h1>
            </div>
            <div class="col-md-10">
                <input id="range" type="range" class="form-control-range mt-3" name="range" min="4" max="20"
                       value="4" step="2">
            </div>
            <div class="col-md-1 text-primary">
                <h1>20</h1>
            </div>
        </div>
        <button id="start_championship" class="btn btn-success btn-lg">Start the championship</button>
    </div>
</div>
<div class="row my-5 text-center">
    <div class="col-md-6 offset-md-3">
        <div class="d-none text-success finished">
            <h1>The championship has been finished!</h1>
        </div>
    </div>
</div>

<div class="championship row mt-5 text-center d-none w-100 mx-1">
    <div class="col-md-6 d-inline-block">
        <h3>League Table</h3>
        <table id="league" class="table table-striped table-bordered table-hover w-100">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th class="w-25">Teams</th>
                <th>PTS</th>
                <th>P</th>
                <th>W</th>
                <th>D</th>
                <th>L</th>
                <th>GF</th>
                <th>GA</th>
                <th>GD</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="text-left mt-3 d-inline-block">
            <button id="play_all" class="btn btn-success btn-lg">Play All</button>
        </div>
        <div class="text-right d-inline-block">
            <button id="next_week" class="btn btn-success btn-lg">Next Week</button>
        </div>
    </div>

    <div class="col-md-3">
        {{--    <div class="col-md-3 d-none">--}}
        <h3>Predictions</h3>
        <table id="predictions" class="table table-striped table-borderless table-hover ">
            <thead class="thead-dark">
            <tr>
                <th colspan="2">
                    <span class="week_number">0</span><span class="week_suffix"></span>
                    Week Predictions of Championship
                </th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


</div>
{{--<div class="championship championship_week row mt-5 text-center d-none w-100 mx-1">--}}
{{--    <div class="col-md-6">--}}
{{--        <h3 class="match-result-caption"><span class="week_number">0</span><span class="week_suffix"></span> Week Matches Results</h3>--}}
{{--        <table id="matches" class="table table-striped table-borderless table-hover w-100">--}}
{{--            <thead class="thead-dark">--}}
{{--            <tr>--}}
{{--                <th>Home</th>--}}
{{--                <th></th>--}}
{{--                <th></th>--}}
{{--                <th></th>--}}
{{--                <th>Guest</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody></tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div id="all_matches" class="row mt-5 text-center d-none w-100 mx-1">--}}
{{--    <div class="col-md-4">--}}
{{--        <h3>All Matches Results</h3>--}}
{{--        <div class="bg-dark text-white font-weight-bold text-center py-2">1st Week Matches Results</div>--}}
{{--        <table id="all_matches_table" class="table table-borderless table-hover w-100">--}}
{{--            <thead class="thead-dark d-none">--}}
{{--            <tr>--}}
{{--                <th></th><th></th><th></th><th></th><th></th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody></tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="championship row mt-5 text-center d-none w-100 mx-1">
    <div class="col-md-6">
        <h3 class="match-result-caption"><span class="week_number">0</span><span class="week_suffix"></span>
            Week Matches Results</h3>
        <div class="bg-dark text-white font-weight-bold text-center py-2 first-week d-none">1st Week Matches Results</div>
        <table id="matches" class="table table-striped table-borderless table-hover w-100">
            <thead class="thead-dark">
            <tr>
                <th>Home</th>
                <th></th>
                <th></th>
                <th></th>
                <th>Guest</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{--    <div id="all_matches" class="row mt-5 text-center d-none w-100 mx-1">--}}
{{--        <div class="col-md-4">--}}
{{--            <h3>All Matches Results</h3>--}}
{{--            <div class="bg-dark text-white font-weight-bold text-center py-2">1st Week Matches Results</div>--}}
{{--            <table id="all_matches_table" class="table table-borderless table-hover w-100">--}}
{{--                <thead class="thead-dark d-none">--}}
{{--                <tr>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody></tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.extend($.fn.dataTable.defaults, {
            searching: false,
            ordering: false,
            paging: false,
            info: false
        });
        $('table').css('border-bottom', 'none');


        let teamCount;
        let playAll = false;

        $('#range').change(function () {
            $('#team_count').html($(this).val());
        });

        $('#start_championship').click(function () {
            teamCount = $('#team_count').html();
            $('#start').hide();
            $('.championship').removeClass('d-none');
            $('#next_week').trigger('click');
        });

        // const createdCell = function(cell) {
        //     let original
        //
        //     cell.setAttribute('contenteditable', true)
        //     cell.setAttribute('spellcheck', false)
        //
        //     cell.addEventListener('focus', function(e) {
        //         original = e.target.textContent
        //     })
        //
        //     cell.addEventListener('blur', function(e) {
        //         if (original !== e.target.textContent) {
        //             const row = table.row(e.target.parentElement)
        //             $.ajax({
        //                 url: '/updateScript/',
        //                 data: row.data()
        //             })
        //         }
        //     })
        // }
        //
        // table = $('#example').DataTable({
        //     columnDefs: [{
        //         targets: '_all',
        //         createdCell: createdCell
        //     }]
        // })

        // let matchesTable = $('#matches').DataTable({
        //     columnDefs: [
        //         {targets: 0, className: 'dt-body-left'},
        //         {targets: -1, className: 'dt-body-right'}
        //         // {targets: 0, className: 'dt-head-left dt-body-left'},
        //         // {targets: -1, className: 'dt-head-right dt-body-right'}
        //     ],
        //     ajax: {
        //         url: '/match-results/',
        //         // url: '/match-results/' + weekNumberDigit,
        //         dataSrc: 'data'
        //     },
        //     columns: [
        //         {data: 'home_name'},
        //         {data: 'home_goals'},
        //         {
        //             data: function () {
        //                 return '-'
        //             }
        //         },
        //         {data: 'guest_goals'},
        //         {data: 'guest_name'}
        //     ]
        // });
        let leagueTable = $('#league').DataTable({
            columnDefs: [
                {targets: 1, className: 'dt-body-left'}
            ],
            ajax: {
                url: '/championship',
                dataSrc: 'data'
            },
            columns: [
                {data: 'position'},
                {data: 'name'},
                {data: 'points'},
                {data: 'played'},
                {data: 'won'},
                {data: 'drawn'},
                {data: 'lost'},
                {data: 'gf'},
                {data: 'ga'},
                {data: 'gd'}
            ]
        });

        let matchesTable = $('#matches').DataTable({
            columnDefs: [
                {targets: 0, className: 'dt-body-left'},
                {targets: -1, className: 'dt-body-right'}
            ],
            ajax: {
                url: '/match-results/',
                dataSrc: 'data'
            },
            createdRow: function (row, data, dataIndex) {
                if (playAll) {
                    if (!isExtraRow) {
                        if (!(matchNumber % (teamCount / 2))) {
                            isExtraRow = true;
                            this.api().row.add(data);
                        }
                        matchNumber++;
                    } else {
                        isExtraRow = false;
                    }
                }
            },
            drawCallback: function (settings) {
                if (playAll) {
                    let counter = 1;
                    let week = 2;
                    this.api().rows().every(function (rowIdx, tableLoop, rowLoop) {
                        if (counter === (teamCount / 2) + 1) {
                            // if (counter === (teamCount / 2) + 1) { //TODO
                            let currentRow = this.nodes().to$();
                            currentRow
                                .find('td:first')
                                .attr('colspan', 5)
                                .html(week + getSuffix(week) + ' Week Matches Results')
                                .addClass('bg-dark text-white font-weight-bold text-center');
                            currentRow.find('td:not(:first)').css('display', 'none');
                            week++;
                            counter = 1;
                        } else {
                            counter++;
                        }
                        // if (rowIdx === 5) {
                        // }
                    });
                }
            },
            columns: [
                {data: 'home_name'},
                {data: 'home_goals'},
                {
                    data: function () {
                        return '-'
                    }
                },
                {data: 'guest_goals'},
                {data: 'guest_name'}
            ]
        });

        $('#next_week').click(function () {
            let weekNumber = $('.week_number');
            let weekNumberDigit = Number(weekNumber.html());

            if ((teamCount * 2 - 2) < (weekNumberDigit + 1)) {
                $('.finished').removeClass('d-none');
                $(this).prop('disabled', true);
            } else {
                weekNumber.html(++weekNumberDigit);
                $('.week_suffix').html(getSuffix(weekNumberDigit));

                leagueTable.ajax.reload();
                matchesTable.ajax.url('/match-results/' + weekNumberDigit).load();
            }
        });

        let matchNumber = 1;
        let isExtraRow = false;

        $('#play_all').click(function () {
            playAll = true;
            $('#next_week').prop('disabled', true);
            $('.match-result-caption').html('All Matches Results');
            $('#matches thead').addClass('d-none');
            $('.first-week').removeClass('d-none');

            matchesTable.ajax.url('/match-results/').load();

            // let allMatchesTable = $('#all_matches_table').DataTable({
            //     columnDefs: [
            //         {targets: 0, className: 'dt-body-left'},
            //         {targets: -1, className: 'dt-body-right'}
            //     ],
            //     ajax: {
            //         url: '/match-results/',
            //         dataSrc: 'data'
            //     },
            //     createdRow: function (row, data, dataIndex) {
            //         if (!isExtraRow) {
            //             if (!(matchNumber % (teamCount / 2))) {
            //                 isExtraRow = true;
            //                 this.api().row.add(data);
            //             }
            //             matchNumber++;
            //         } else {
            //             isExtraRow = false;
            //         }
            //     },
            //     drawCallback: function (settings) {
            //         let counter = 1;
            //         let week = 2;
            //         this.api().rows().every(function (rowIdx, tableLoop, rowLoop) {
            //             if (counter === (teamCount / 2) + 1) {
            //                 // if (counter === (teamCount / 2) + 1) { //TODO
            //                 let currentRow = this.nodes().to$();
            //                 currentRow
            //                     .find('td:first')
            //                     .attr('colspan', 5)
            //                     .html(week + getSuffix(week) + ' Week Matches Results')
            //                     .addClass('bg-dark text-white font-weight-bold text-center');
            //                 currentRow.find('td:not(:first)').css('display', 'none');
            //                 week++;
            //                 counter = 1;
            //             } else {
            //                 counter++;
            //             }
            //             // if (rowIdx === 5) {
            //             // }
            //         });
            //     },
            //     columns: [
            //         {data: 'home_name'},
            //         {data: 'home_goals'},
            //         {
            //             data: function () {
            //                 return '-'
            //             }
            //         },
            //         {data: 'guest_goals'},
            //         {data: 'guest_name'}
            //     ]
            // })

            $('#all_matches').removeClass('d-none');
        });
    });

    function getSuffix(number) {
        switch (number) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
            default:
                return 'th';
        }
    }
</script>
</body>
</html>

