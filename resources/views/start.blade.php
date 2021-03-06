<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <style>
        span.minus,span.plus, #range {
            cursor: pointer;
        }
    </style>
</head>
<body class="pr-4 bg-light">
<div id="start" class="row mt-5 text-center">
    <div class="col-md-4 offset-md-4">
        <h1 class="display-5">Choose the quantity of teams</h1>
        <h1 id="team_count" class="display-3 text-primary">4</h1>
        <div class="row mb-4">
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

        <div class="row mt-4">
            <div class="w-100">
                <h3>Team's List</h3>
                <table id="teams" class="table table-bordered w-100">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Team</th>
                        <th>Strength</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row my-3 text-center">
    <div class="col-md-6 offset-md-3">
        <div class="d-none text-success finished">
            <h1>The championship has been finished!</h1>
        </div>
    </div>
</div>

<div class="championship d-none row">
    <div class="col-md-4 offset-md-4 text-center">
        <div class="play_again text-right d-none">
            <button id="play_again" class="btn btn-success btn-lg">Play Championship Again</button>
        </div>
        <div class="d-inline-block">
            <button id="play_all" class="btn btn-success btn-lg">Play All</button>
        </div>
        <div class="d-inline-block">
            <button id="next_week" class="btn btn-success btn-lg">Next Week</button>
        </div>

    </div>
</div>

<div class="championship row mt-3 text-center d-none w-100 mx-1">
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
    </div>

    <div class="col-md-4">
        <h3 class="match-result-caption"><span class="week_number">0</span><span class="week_suffix"></span>
            Week Matches Results</h3>
        <div class="bg-dark text-white font-weight-bold text-center py-2 first-week d-none">1st Week Matches Results
        </div>
        <table id="matches" class="table table-bordered table-hover w-100">
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

    <div class="col-md-2 predictions d-none">
        <h3><span class="week_number">0</span><span class="week_suffix"></span> Week</h3>
        <table id="predictions" class="table table-striped table-bordered table-hover w-100">
            <thead class="thead-dark">
            <tr>
                <th>Team</th>
                <th>%</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
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
        let matchNumber = 1;
        let isExtraRow = false;
        let predictionWeekAppearance;

        const createdCell = function (cell) {
            let original;

            cell.setAttribute('contenteditable', true);
            cell.setAttribute('spellcheck', false);

            cell.addEventListener('focus', function (e) {
                original = e.target.textContent;
            })

            cell.addEventListener('blur', function (e) {
                if (original !== e.target.textContent) {
                    if (Number.isInteger(Number(e.target.textContent))) {
                        const row = matchesTable.row(e.target.parentElement);
                        let params = {
                            home_name: row.data().home_name,
                            week: row.data().week,
                            home_goals: e.path[0]._DT_CellIndex.column === 1 ? e.target.textContent : row.data().home_goals,
                            guest_goals: e.path[0]._DT_CellIndex.column === 3 ? e.target.textContent : row.data().guest_goals
                        }
                        $.post('/match-update', params, function (message, status) {
                            if (message === 'ok' && status === 'success') {
                                let week = row.data().week;
                                if (playAll) {
                                    week = '';
                                }
                                matchesTable.ajax.url('/match-results/' + week).load();
                            }
                        });
                    } else {
                        alert('The goal value should be an integer')
                    }
                }
            })
        }

        let predictionsTable = $('#predictions').DataTable({
            scrollY: 650,
            columnDefs: [
                {targets: 0, className: 'dt-head-left, dt-body-left'},
                {targets: -1, className: 'dt-head-right, dt-body-right'},
            ],
            ajax: {
                url: '/prediction',
                dataSrc: 'data'
            },
            columns: [
                {
                    data: function (match) {
                        return '<img src="/img/' + match.team_id + '.png">' + ' ' + match.name;
                    }
                },
                {data: 'percent'}
            ]
        });

        let teamsTable = $('#teams').DataTable({
            scrollY: 450,
            columnDefs: [
                {targets: 1, className: 'dt-body-left'},
            ],
            ajax: {
                url: '/teams-list/' + $('#team_count').html(),
                dataSrc: 'data'
            },
            columns: [
                {data: 'team_id'},
                {
                    data: function (team) {
                        return '<img src="/img/' + team.team_id + '.png">' + ' ' + team.name;
                    }
                },
                {
                    data: function (team) {
                        return '<span class="minus"><img src="/img/minus.jpg" width="25px" height="25px"></span>'
                            + '<span class="strength px-4" data-team-id="' + team.team_id + '">1</span>'
                            + '<span class="plus"><img src="/img/plus.jpg" width="25px" height="25px"></span>';
                    }
                },
            ]
        });

        let leagueTable = $('#league').DataTable({
            scrollY: 650,
            columnDefs: [
                {targets: 1, className: 'dt-body-left'}
            ],
            ajax: {
                url: '/championship',
                dataSrc: 'data'
            },
            columns: [
                {
                    data: function (team) {
                        let caret = 'W';
                        switch (team.is_up) {
                            case 0:
                                caret = 'circle';
                                break;
                            case -1:
                                caret = 'down';
                                break;
                            case 1:
                                caret = 'up';
                                break;
                        }
                        if (Number($('.week_number').html()) === 1) {
                            return team.pos;
                        }
                        return team.pos + ' ' + '<img src="/img/' + caret + '.png" width="10px" height="10px">';
                    }
                },
                {
                    data: function (team) {
                        return '<img src="/img/' + team.team_id + '.png">' + ' ' + team.name;
                    }
                },
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
            scrollY: 600,
            columnDefs: [
                {targets: 0, className: 'dt-body-left'},
                {targets: -1, className: 'dt-body-right'},
                {targets: 1, createdCell: createdCell},
                {targets: 3, createdCell: createdCell},
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
            drawCallback: function () {
                if (playAll) {
                    let counter = 1;
                    let week = 2;
                    this.api().rows().every(function (rowIdx) {
                        if (counter === (teamCount / 2) + 1) {
                            let currentRow = this.nodes().to$();
                            if (rowIdx === teamCount * teamCount - teamCount + 2 * teamCount - 3) {
                                currentRow.css('display', 'none');
                            } else {
                                currentRow
                                    .find('td:first')
                                    .attr('colspan', 5)
                                    .html(week + getSuffix(week) + ' Week Matches Results')
                                    .addClass('bg-dark text-white font-weight-bold text-center');
                                currentRow.find('td:not(:first)').css('display', 'none');
                                week++;
                                counter = 1;
                            }
                        } else {
                            counter++;
                        }
                    });
                }
                leagueTable.ajax.reload();
                if (Number($('.week_number').html()) >= predictionWeekAppearance) {
                    predictionsTable.ajax.reload();
                }
            },
            columns: [
                {
                    data: function (match) {
                        return '<img src="/img/' + match.home_team_id + '.png">' + ' ' + match.home_name;
                    }
                },
                {data: 'home_goals'},
                {
                    data: function () {
                        return '-';
                    }
                },
                {data: 'guest_goals'},
                {
                    data: function (match) {
                        return match.guest_name + ' ' + '<img src="/img/' + match.guest_team_id + '.png">';
                    }
                }
            ]
        });

        $('.dataTables_wrapper.no-footer .dataTables_scrollBody').css('border-bottom', 'none');

        $('#range').change(function () {
            $('#team_count').html($(this).val());
            teamsTable.ajax.url('/teams-list/' + $(this).val()).load();
        });

        $(document).on('hover', 'span.minus,span.plus', function () {
            $(this).css('cursor', 'pointer');
        });
        $(document).on('click', 'span.plus', function () {
            let strengthElem = $(this).siblings('.strength');
            let strength = Number(strengthElem.html());
            if (strength < 3) {
                strengthElem.html(strength + 1);
            }
        });
        $(document).on('click', 'span.minus', function () {
            let strengthElem = $(this).siblings('.strength');
            let strength = Number(strengthElem.html());
            if (strength > 1) {
                strengthElem.html(strength - 1);
            }
        });

        $('#start_championship').click(function () {
            teamCount = $('#team_count').html();
            predictionWeekAppearance = 2 * teamCount - 4;

            let strengths = [];
            $('#teams tr .strength').each(function () {
                strengths[$(this).data('team-id')] = $(this).html();
            });

            let params = {
                team_count: teamCount,
                strengths: strengths
            };
            $.post('/generate', params, function (data, status) {
                if (data === 'ok' && status === 'success') {
                    $('#start').hide();
                    $('.championship').removeClass('d-none');
                    $('#next_week').trigger('click');
                }
            });
        });

        $('#next_week').click(function () {
            let weekNumber = $('.week_number');
            let weekNumberDigit = Number(weekNumber.html());

            weekNumber.html(++weekNumberDigit);
            $('.week_suffix').html(getSuffix(weekNumberDigit));

            matchesTable.ajax.url('/match-results/' + weekNumberDigit).load();

            if ((teamCount * 2 - 2) === weekNumberDigit) {
                $('.finished').removeClass('d-none');
                $(this).prop('disabled', true);
                $('.play_again').removeClass('d-none').addClass('d-inline-block');
            }
            if (weekNumberDigit === predictionWeekAppearance) {
                $('.predictions').removeClass('d-none');
            }
        });

        $('#play_all').click(function () {
            playAll = true;
            $('.finished').removeClass('d-none');
            $('#next_week').prop('disabled', true);
            $('.match-result-caption').html('All Matches Results');
            $('.first-week').removeClass('d-none');
            $('#all_matches').removeClass('d-none');
            $('.play_again').removeClass('d-none').addClass('d-inline-block');

            matchesTable.ajax.url('/match-results/').load();
        });

        $('#play_again').click(function () {
            window.location.reload();
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

