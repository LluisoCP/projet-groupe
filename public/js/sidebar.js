$.noConflict();
jQuery(document).ready(function ($) {
    
    $('#maxprice').change(function() {
        $('#price-selected').text($(this).val() + '€')
    });
    // jQuery Accordion
    $(function () {
        $("#accordion").accordion({
            heightStyle: "content",
            header: "h2",
            collapsible: true,
            active: false,
            icons: { "header": "ui-icon-triangle-1-s", "activeHeader": "ui-icon-triangle-1-n" }
        });
    });

    // $('#accordion h2').click(function() {
    //     $('#results').fadeOut();
    // })

    const   trigger = $('#lance-recherche'),
            results = $('#results');
            
    trigger.on('click', function() {
        results.html('');
        $('#no-products').remove();
        let order = $('input[type="radio"]:checked').val(),
            price = $('#maxprice').val(),
            nom = $('#nom').val();
            console.log('Prix: ' + price + ' en ordre ' + order + ' avec mot ' + nom);
            // nom = nom.length == 0 ? 'null' : nom;
        $.ajax({
            url: 'produits/results',
            type: 'GET',
            dataType: 'json',
            data: {
                order: order,
                price: price, 
                nom: nom
            },
            beforeSend: function () {
                
                results.append('<div id="spinner" class="text-center mt-5"><i id="spinning" class="fas fa-spinner"></i></div>');
            },
            success: function(products) {
                console.log(products);
                if (!products.length) {
                    results.append('<p class="text-center mt-3" style="color:red;">Pas de produits</p>');
                } else {

                    results.append('<ul id="list-results" class="list-group list-group-flush">');
                    for (let product of products) {
                        results.append('<li class="bg-warning list-group-item"><a href="/produits/produit/' + product.id + '">' + product.nom + '</a> (' + product.categorie.nom + ') - '+ product.prix +'€</li>')
                    }
                    results.append('</ul">');
                }

            },
            error: function(err) {
                console.log(err);
            },
            complete: function() {
                console.log('Terminé.');
                $('#spinner').remove();
            }
        })
    });
})