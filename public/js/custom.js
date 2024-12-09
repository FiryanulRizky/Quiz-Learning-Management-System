jQuery(function(){
    $('.delete-item').submit(function(e){
        if(!confirm('Apakah Anda yakin untuk menghapus item ini?')){
            e.preventDefault();
            return false;
        }
    });
})