var sort_type_deals = 'DESC';

$(document).ready(function () {

    $('input[name="duration_date_range"]').daterangepicker({
        startDate: current_date_month,
        endDate: current_end_date_month,
        locale: {
                format: 'DD/MM/YYYY'
        },
    }, function(start, end, label) {
        localStorage.removeItem("range_select_date");
        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    let selectedDate = localStorage.getItem("range_select_date");
    if(selectedDate) {
        $('#duration_date_range').val(selectedDate);
    }
    
    $('input[name="duration_date_range"]').on('apply.daterangepicker', function(ev, picker) {
        initDashboard();
    });

    $('#select_preferred_dashboard').on('change', function (e) {
        e.preventDefault();
        var self = $(this);
        initDashboard();
    });

    $('#select_currency_type').on('change', function (e) {
        e.preventDefault();
        var self = $(this);
        initDashboard();
    });

    $('#sort_type_lates_deals').on('change', function (e) {
        e.preventDefault();
        var self = $(this);
        sort_type_deals = self.val();
        initDashboard();
    });

    initDashboard();
});
// end document ready

$(document).on('click', '.evt_click_dashboard_details', function (e) {
    e.preventDefault();
    var self = $(this);
    var url_link = self.attr('data-href');
    var link = document.createElement("a")
    link.href = url_link
    // link.target = "_blank"
    link.click();
})

$(document).on('click', '.evt_user_type_tab', function (e) {
    e.preventDefault();
    var self = $(this);
    $('.evt_user_type_tab').removeClass('active');
    $(this).addClass('active');
    $('#select_preferred_dashboard').val($(this).attr('data-val'))
    initDashboard();
});


$(document).on('click', '.evt_currency_type_tab', function (e) {
    e.preventDefault();
    var self = $(this);
    $('.evt_currency_type_tab').removeClass('active');
    $(this).addClass('active');
    $('#select_currency_type').val($(this).attr('data-val'))
    initDashboard();
});


function initDashboard() {
    // setLoadin(); 
    var currency_type = $('#select_currency_type').val();
    var duration_date_range = $('#duration_date_range').val();
    var select_preferred = $('#select_preferred_dashboard').val();

    localStorage.setItem("range_select_date", duration_date_range);

    var formData = {
        'currency_type': currency_type,
        'duration_date_range': duration_date_range,
        'preferred_dashboard': select_preferred,
        'sort_type_deals': sort_type_deals,
    };
    
    $.ajax({
        type: "POST",
        url: url_ajax_dashboard_type,
        data: formData,
        dataType: 'json',
        cache: false,
        success: function (res) {
            if (res.status == true) {
                var res_data = res.data[0];

                if(select_preferred == 'Investor') {
                    $('#dsh_pie_chart_title').text(dsh_buyer_pie_chart_title_en_msg);
                    $('#dsh_pie_chart_sub_title').text(dsh_buyer_pie_chart_sub_title_en_msg);
                } else {
                    $('#dsh_pie_chart_title').text(dsh_seller_pie_chart_title_en_msg);
                    $('#dsh_pie_chart_sub_title').text(dsh_seller_pie_chart_sub_title_en_msg);
                }
                $('#ajax_first_div').html(res_data.first_section);

                $('#ajax_latest_update_in_deals_table_div').html(res_data.second_section);

                $('#ajax_last_section_div').html(res_data.last_section);

                initPieChart(res_data.pichart);
                initLineChart();
                // initGaugeChart();
                initowlCarousel();

                // initBarChart(res_data);
                // toastr.success(res.message);
                /*   toastr.error(res.message);
                console.log(res.message); */
            } else {
                toastr.error(res.message);
            }
            // unsetLoadin();
        },
        error: function (xhr) {
            // unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
}

function initPieChart(res_pichart) {
    const pichart_data_obj = {
        labels: res_pichart.labels,
        datasets: [{
            // label: 'OPERATIONS',
            data: res_pichart.data,
            backgroundColor: [
                'rgb(13, 110, 253, 1.0)',
                'rgb(13, 110, 253, 0.8)',
                'rgb(13, 110, 253, 0.6)',
                'rgb(13, 110, 253, 0.4)',
            ],
            hoverOffset: 4
        }]
    };

    $('#div_pie_chart_deals').empty();

    var canvas = document.createElement("canvas");
    canvas.setAttribute("id", "pie_chart_deals");

    $('#div_pie_chart_deals').html(canvas);

    new Chart(document.getElementById('pie_chart_deals'), {
        type: 'pie',
        data: pichart_data_obj,
        options: {
            plugins: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        }
    });
}

function initBarChart(res_data) {
    if (res_data.preferred_dashboard == 'borrower') {
        if (res_data.borrower.finalized_deals) {
            const labels = Object.keys(res_data.borrower.finalized_deals)
            const datas = Object.values(res_data.borrower.finalized_deals)

            const barchart_finalized_deals_borrow_obj = {
                labels: labels,
                datasets: [{
                    label: 'Finalized Deals',
                    data: datas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            };

            $('body #barchart_finalized_deals_borrow').empty();

            var canvas = document.createElement("canvas");
            canvas.setAttribute("id", "barchart_finalized_deals");

            $('body #barchart_finalized_deals_borrow').html(canvas);

            new Chart(document.getElementById('barchart_finalized_deals'), {
                type: 'bar',
                data: barchart_finalized_deals_borrow_obj,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }

        if (res_data.borrower.deals_in_progress) {
            const labels = Object.keys(res_data.borrower.deals_in_progress)
            const datas = Object.values(res_data.borrower.deals_in_progress)

            const barchart_deals_in_progress_borrow_obj = {
                labels: labels,
                datasets: [{
                    label: 'Deals',
                    data: datas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            };

            $('body #barchart_deals_borrow').empty();

            var canvas = document.createElement("canvas");
            canvas.setAttribute("id", "barchart_deals_div");

            $('body #barchart_deals_borrow').html(canvas);

            new Chart(document.getElementById('barchart_deals_div'), {
                type: 'bar',
                data: barchart_deals_in_progress_borrow_obj,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }
    } else if (res_data.preferred_dashboard == 'investor') {
        if (res_data.investor.incomes) {
            const labels = Object.keys(res_data.investor.incomes)
            const datas = Object.values(res_data.investor.incomes)

            const barchart_incomes_investor_obj = {
                labels: labels,
                datasets: [{
                    label: 'Incomes',
                    data: datas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            };

            $('body #barchart_incomes_investor').empty();

            var canvas = document.createElement("canvas");
            canvas.setAttribute("id", "barchart_incomes_canvas");

            $('body #barchart_incomes_investor').html(canvas);

            new Chart(document.getElementById('barchart_incomes_canvas'), {
                type: 'bar',
                data: barchart_incomes_investor_obj,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }

        if (res_data.investor.deals_in_progress) {
            const labels = Object.keys(res_data.investor.deals_in_progress)
            const datas = Object.values(res_data.investor.deals_in_progress)

            const barchart_deals_investor_obj = {
                labels: labels,
                datasets: [{
                    label: 'Deals',
                    data: datas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            };

            $('body #barchart_deals_investor').empty();

            var canvas = document.createElement("canvas");
            canvas.setAttribute("id", "barchart_deals_investor_canvas");

            $('body #barchart_deals_investor').html(canvas);

            new Chart(document.getElementById('barchart_deals_investor_canvas'), {
                type: 'bar',
                data: barchart_deals_investor_obj,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }
    }
}

function initGaugeChart() {
    $('#div_gauge_chart_risk_managment').empty();

    var canvas = document.createElement("canvas");
    canvas.setAttribute("id", "gauge_chart_risk_managment");

    $('#div_gauge_chart_risk_managment').html(canvas);

    const gauge_data_obj = $('body #gauge_chart_data');

    new Chart(document.getElementById('gauge_chart_risk_managment'), {
        type: 'gauge',
        data: {
        // labels: [],
          datasets: [{
            value: 50,
            minValue: 0,
            data: [gauge_data_obj.attr('data-selfrisk-amount'), gauge_data_obj.attr('data-gauranteed-amount'),  gauge_data_obj.attr('data-total-invested-amount')],
            backgroundColor: ['red', 'yellow', 'green'],
          }]
        },
        options: {
          needle: {
            radiusPercentage: 2,
            widthPercentage: 3.2,
            lengthPercentage: 80,
            color: 'rgba(0, 0, 0, 1)'
          },
          valueLabel: {
            display: true,
            formatter: (value) => {
              return gauge_data_obj.attr('data-currency-symbol') + gauge_data_obj.attr('data-selfrisk-amount');
            },
            color: 'rgba(255, 255, 255, 1)',
            backgroundColor: 'rgba(0, 0, 0, 1)',
            borderRadius: 5,
            padding: {
              top: 10,
              bottom: 10
            }
          }
        }
    });
}

function initLineChart() {
    setTimeout(() => {
        const line_data_obj = $('body #line_chart_data');
        if($('body #line_chart_data').prop('name') === 'line_chart_data') {
            const line_chart_operation_data = JSON.parse(line_data_obj.attr('data-line-chart-operation'));
            const line_chart_offers_data = JSON.parse(line_data_obj.attr('data-line-chart-offer'));
            const line_chart_lable = JSON.parse(line_data_obj.attr('data-line-chart-lable'));
            const line_lable_first = (line_data_obj.attr('data-line-label-first'));
            const line_lable_second = (line_data_obj.attr('data-line-label-second'));
    
            const line_data = {
                labels: line_chart_lable,
                datasets: [
                    {
                        label: line_lable_second,
                        data: line_chart_offers_data,
                    },
                    {
                        label: line_lable_first,
                        data: line_chart_operation_data,
                    }
                ]
            };
    
            $('body #div_line_chart_finalized_operations_borrower').empty();
    
            var canvas = document.createElement("canvas");
            canvas.setAttribute("id", "line_chart_finalized_operations_borrower");
    
            $('body #div_line_chart_finalized_operations_borrower').html(canvas);
    
            new Chart(document.getElementById('line_chart_finalized_operations_borrower'), {
                type: 'line',
                data: line_data,
                options: {
                    plugins: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                    }
                }
            });
        }
    }, 1000);
}

$(document).on('click', '.evt_deals_details', function (event) {
    event.preventDefault();
    var details_link = $(this).attr('data-deals-details-link');
    window.location.href = details_link;
});

$(document).on('click', '.evt_target_link', function(e){
    e.preventDefault(); 
    var target_link = $(this).attr('data-href');
    window.location.href = target_link;
});
// dashboard slider by k

function initowlCarousel () {
    $('.mobile_slider_section').owlCarousel({
        items : 1,
        loop : true,
        margin : 12,
        stagePadding : 20,
        slideBy : 1,
        dots : false,
        nav : false,
    });
}
// dashboard slider by k