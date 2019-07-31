const lien = document.getElementsByClassName('lien');

jQuery('.lien').on('mouseover', action);
function action() 
{
    $(this).css('color', 'goldenrod');
}

jQuery('.lien').on('mouseleave', reaction);
function reaction() 
{
    $(this).css('color', 'rgba(253, 249, 40, 0.87)');
}
