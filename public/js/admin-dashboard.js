document.addEventListener("DOMContentLoaded", () => {
    const data = window.dashboardData;

    // === Status Bar Chart ===
    const wrapLabel = (label) => {
        const maxCharsPerLine = 10;
        const words = label.split(" ");
        let lines = [];
        let currentLine = "";

        for (const word of words) {
            if ((currentLine + word).length > maxCharsPerLine) {
                lines.push(currentLine.trim());
                currentLine = word + " ";
            } else {
                currentLine += word + " ";
            }
        }
        lines.push(currentLine.trim());
        return lines;
    };

    const wrappedLabels = (data.statusLabels || []).map(l => wrapLabel(l));

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx && wrappedLabels.length && data.statusData) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: wrappedLabels,
                datasets: [{
                    label: 'Jumlah Permohonan per Status',
                    data: data.statusData,
                    backgroundColor: [
                        '#fdbd0dff',
                        '#0b41f5ff',
                        '#ff6207ff',
                        '#0ae3ebff',
                        '#198754',
                        '#eb1111ff',
                    ],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: {
                            font: { size: 12 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // === Trend Chart (Dynamic: Monthly or Daily) ===
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        const labels = data.isMonthly ? (data.monthlyLabels || []) : (data.dailyLabels || []);
        const permohonan = data.isMonthly ? (data.monthlyPermohonan || []) : (data.dailyPermohonan || []);
        const keberatan = data.isMonthly ? (data.monthlyKeberatan || []) : (data.dailyKeberatan || []);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Permohonan',
                        data: permohonan,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Keberatan',
                        data: keberatan,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // === Pekerjaan Pie Chart ===
    const pekerjaanCtx = document.getElementById('pekerjaanChart');
    const pekerjaanLabels = data.pekerjaanLabels || [];
    const pekerjaanCounts  = data.pekerjaanCounts || data.pekerjaanCounts || [];

    if (pekerjaanCtx && pekerjaanLabels.length && pekerjaanCounts.length) {
        const pekerjaanColors = pekerjaanLabels.map((_, idx) => {
            const palette = [
                '#0d6efd',
                '#198754',
                '#ffc107',
                '#dc3545',
                '#0dcaf0',
                '#6f42c1',
                '#6c757d',
                '#cd65f7ff',
            ];
            return palette[idx % palette.length];
        });

        new Chart(pekerjaanCtx, {
            type: 'pie',
            data: {
                labels: pekerjaanLabels,
                datasets: [{
                    data: pekerjaanCounts,
                    backgroundColor: pekerjaanColors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
});

// Time filter
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect  = document.getElementById('year');
    const monthSelect = document.getElementById('month');

    if (!yearSelect || !monthSelect) return;

    function updateMonthState() {
        if (yearSelect.value === 'semua') {
            monthSelect.value = 'semua';
            monthSelect.setAttribute('disabled', 'disabled');
        } else {
            monthSelect.removeAttribute('disabled');
        }
    }

    updateMonthState();
    yearSelect.addEventListener('change', updateMonthState);
});