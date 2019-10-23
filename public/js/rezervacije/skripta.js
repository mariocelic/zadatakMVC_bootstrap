$("#uvjet").autocomplete({
  source: function( request, response ) {
    $.ajax( {
      url: "/kupac/trazikupac",
      data: {
        uvjet: request.term,
        rezervacija: rezervacija
      },
      success: function( data ) {
        response( data );
      }
    } );
  },
  minLength: 1,
  select: function( event, ui ) {
      console.log( "Idem na server s: " + rezervacija + " i " + ui.item.sifra );
  }
} ).autocomplete( "instance" )._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append( "<div>" + item.ime + " " + item.prezime + "</div>" )
    .appendTo( ul );
};






