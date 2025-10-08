document.addEventListener("DOMContentLoaded", () => {
    const data = window.dashboardData;

    // === Status Bar Chart (already implemented) ===
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

    const wrappedLabels = data.statusLabels.map(l => wrapLabel(l));

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: wrappedLabels,
                datasets: [{
                    label: 'Jumlah Permohonan per Status',
                    data: data.statusData,
                    backgroundColor: [
                        '#0d6efd',
                        '#17a2b8',
                        '#ffc107',
                        '#6f42c1',
                        '#198754'
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
        const labels = data.isMonthly ? data.monthlyLabels : data.dailyLabels;
        const permohonan = data.isMonthly ? data.monthlyPermohonan : data.dailyPermohonan;
        const keberatan = data.isMonthly ? data.monthlyKeberatan : data.dailyKeberatan;

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
});
