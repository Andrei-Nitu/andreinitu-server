<?php $this->assign('title', 'Patient');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($auth_user['role'] == 'doctor'): ?>
        <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Html->link(__('List Patients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Patient'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('New Patient'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('New Diagnostic'), ['_name' => 'addhistory', $user->id]) ?> </li>
        <li><?= $this->Html->link(__('List Doctors'), ['action' => 'listDoctor']) ?></li>
        <?php endif; ?>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h4><?= h($user->name) ?></h4>
    <table class="vertical-table">
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Alert heartbeat value') ?></th>
            <td><?= h($user->alert_value) ?></td>
        </tr>
        <tr>
            <th><?= __('Address') ?></th>
            <td><?= h($user->address) ?></td>
        </tr>
        <tr>
            <th><?= __('Birthday') ?></th>
            <td><?= h($user->birthday) ?></td>
        </tr>
    </table>

    <br/><br/>
    <h4>
        Heartbeat
        <select name="chart-period" class="pull-right" style="display: inline-block; width: auto">
            <option value="day">Last day</option>
            <option value="month">Last month</option>
            <option value="year">Last year</option>
        </select>
    </h4>
    <div id="container">
    </div>

    <br/><br/>
    <h4>Diagnostics</h4>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('diagnostic') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($user->histories as $history): ?>
            <tr>
                <td><?= h($history->diagnostic) ?></td>
                <td><?= h($history->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Histories', 'action' => 'view', $history->id]) ?>
                    <?php if ($auth_user['role'] == 'doctor'): ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Histories', 'action' => 'edit', $history->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Histories', 'action' => 'delete', $history->id], ['confirm' => __('Are you sure you want to delete # {0}?', $history->id)]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function updateChart(data) {
        $('#container').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Heartbeat'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Value'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Heartbeat',
                data: data
            }]
        });
    }
    $(function () {
        $.getJSON('/heartbeats/index/<?= $user->id ?>.json?callback=?&period=day', function (data) {
            updateChart(data);
        });
    });
    $(document).ready(function() {
        $('select[name="chart-period"]').change(function() {
            var $val = $(this).val();
            console.log($val);
            $.getJSON('/heartbeats/index/<?= $user->id ?>.json?callback=?&period='+$val, function (data) {
                updateChart(data);
            });
        });
    });
</script>
