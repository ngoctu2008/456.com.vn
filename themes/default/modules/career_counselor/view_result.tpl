<!-- BEGIN: main -->
<div class="career-result">
    <h1 class="text-center">{LANG.your_result}</h1>

    <div class="row">
        <div class="col-md-6">
            <canvas id="radarChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>{LANG.dominant_type}: {RESULT.dominant_group}</h3>
            <p>{RESULT.summary_text}</p>

            <a href="{URL_CHAT}" class="btn btn-success btn-lg btn-block"><i class="fa fa-comments"></i> {LANG.chat_with_counselor}</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('radarChart').getContext('2d');
    var scores = {RESULT.scores_json};
    var labels = Object.keys(scores);
    var data = Object.values(scores);

    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: '{LANG.holland_score}',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scale: {
                ticks: { beginAtZero: true }
            }
        }
    });
</script>
<!-- END: main -->
