document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('categories').getContext('2d');
    
    var categGraph = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: JSON.parse('{{ categNom|raw|json_encode|escape(',html_attr,') }}'),
            datasets: [{
                label: 'Répartition des catégories',
                data: JSON.parse('{{ categCount|raw|json_encode|escape(',html_attr,') }}'),
                backgroundColor: JSON.parse('{{ categColor|raw|json_encode|escape(',html_attr,') }}')
            }]
        }
    });
});