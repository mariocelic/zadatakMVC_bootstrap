$("#uvjet").autocomplete({
  source: function( request, response ) {
    $.ajax( {
      url: "/soba/trazisoba",
      data: {
        uvjet: request.term,
        slikasobe: slikasobe
      },
      success: function( data ) {
        response( data );
      }
    } );
  },
  minLength: 1,
  select: function( event, ui ) {
      console.log( "Idem na server s: " + slikasobe + " i " + ui.item.sifra );
  }
} ).autocomplete( "instance" )._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append( "<div>" + item.slika + "</div>")
    .appendTo( ul );
};






