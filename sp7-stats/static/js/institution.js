$(function () {
  const year_select = $('#year_select');
  const month_select = $('#month_select');

  const days_chart = document.getElementById('days_chart').getContext('2d');
  const months_chart = document.getElementById('months_chart').getContext('2d');

  let selected_year = '';
  let selected_month = '';

  const days_chart_object = create_chart(
    days_chart,
    'Sessions per day',
    [],
    [],
    {
      onClick: () => {
        //redirect to main page when clicked on the day

        const selected_day =
          days_chart_object.chart.getElementAtEvent(event)[0]._model.label;
        const parameters =
          selected_year + ' ' + selected_month + ' ' + selected_day;
        const encoded_parameters = parameters.split(' ').join('+');

        window.location.href = link + encoded_parameters;
      },
    }
  );

  const months_chart_object = create_chart(
    months_chart,
    'Sessions per month',
    [],
    [],
    {
      onClick: () => {
        //change the selected months when clicked on the graph

        const selected_month =
          months_chart_object.chart.getElementAtEvent(event)[0]._model.label;

        month_select
          .find('option')
          .filter(function () {
            return $(this).text() === selected_month;
          })
          .prop('selected', true);

        month_change_function();
      },
    }
  );

  function year_change_function() {
    selected_year = year_select.find('option:selected').val();
    month_select.html('');

    $.each(months[selected_year][0], function (keys, months) {
      month_select.append(
        '<option value="' + months + '">' + months + '</option>'
      );
    });

    if (chosen_month === '')
      month_select.find('option:last-child').attr('selected', 'selected');
    else {
      month_select
        .find('option')
        .filter(function () {
          return $(this).text() === chosen_month;
        })
        .prop('selected', true);

      chosen_month = '';
    }

    month_change_function();

    months_chart_object.tooltip._chart.config.data.labels =
      months[selected_year][0];
    months_chart_object.tooltip._chart.config.data.datasets[0].data =
      months[selected_year][1];
    months_chart_object.update();
  }

  if (chosen_year === '')
    //select last year if none selected
    year_select.find('option:last-child').attr('selected', 'selected');
  else {
    year_select
      .find('option')
      .filter(function () {
        return $(this).text() === chosen_year;
      })
      .prop('selected', true);
  }

  year_select.change(year_change_function);
  year_change_function();

  function month_change_function() {
    selected_month = month_select.find('option:selected').val();

    days_chart_object.tooltip._chart.config.data.labels =
      days[selected_year][selected_month][0];
    days_chart_object.tooltip._chart.config.data.datasets[0].data =
      days[selected_year][selected_month][1];
    days_chart_object.update();
  }

  month_select.change(month_change_function);
});
