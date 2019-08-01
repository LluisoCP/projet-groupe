$.noConflict();
jQuery(document).ready(function ($) {
    
    // Demarrer le slider (qui ne marche pas)
    // $('input[type="range"]').rangeslider();

    // A la place, j'enregistre le prix choisi
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


    const   trigger = $('#lance-recherche');
    const   results = document.getElementsByClassName('resultat')[0];
            //results = $('.resultat');
            console.log(results);
    trigger.on('click', function() {
        //results.html('');
        //results.empty();
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
                
                results.innerHTML='<div id="spinner" class="text-center mt-5"><i id="spinning" class="fas fa-spinner"></i></div>';
            },
            success: function(products) {
                console.log(products);
                if (!products.length) {
                    //results.append('<p class="text-center mt-3" style="color:red;">Pas de produits</p>');
                    results.innerHTML='<p class="text-center mt-3" style="color:red;">Pas de produits</p>';
                } else {

                    
                    for (let produit of products) 
                    {
                        /*results.append
                        //(
                            article.className = "col-4 card py-2";
                            
                            const image = document.createElement('img');
                            image.src = 'file:///C:/Users/Etudiant/Desktop/projet-groupe/public/img/produits/'+produit.image;
                            image.className = "card-img-top";
                            
                            article.appendChild(image);
                            console.log(image)
                            console.log(article);*/
                        
                        const article = document.createElement('article');
                        results.appendChild(article);

                        article.innerHTML=
                            '<img src="/img/produits/'+produit.image+'" class="card-img-top pic_taille">'+
                            '<div class="card_body">'+
                                '<h5>'+ produit.nom +'</h5>'+
                                '<ul class="list-group-item">'+
                                    '<li>modele: '+ produit.reference +'</li>'+
                                    '<li>marque: '+ produit.marque +'</li>'+
                                    '<li>Description: '+ produit.description +'</li>'+
                                    '<li>Stock: '+ produit.stock +'</li>'+
                                    '<li>Prix: '+ produit.prix +'€</li>'+
                                    '<a href="produits/produit/'+produit.id+'" class="btn btn-success">Voir Produit</a>'+
                                '</ul>'+
                            '</div>'+
                        '</article>';
                        
                    }
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
//'<li class="bg-warning list-group-item"><a href="/produits/produit/' + product.id + '">' + product.nom + '</a> (' + product.categorie.nom + ') - ' + product.prix + '€</li>',