const ctx = document.getElementById('barchart').getContext('2d');
const barchart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const ctx2 = document.getElementById('doughnut').getContext('2d');
const doughnut = new Chart(ctx2, {
  type: 'doughnut',
  data: {
      labels: ['A', 'B', 'C', 'D', 'E', 'F'],
      datasets: [{
          label: '# of Votes',
          data: [8, 15, 5, 10, 6, 9],
          borderWidth: 1,
          backgroundColor: ['red', 'blue', 'yellow', 'green', 'purple', 'orange']
      }]
  },
  options: {
      scales: {
          y: {
              beginAtZero: true
          }
      }
  }
});
