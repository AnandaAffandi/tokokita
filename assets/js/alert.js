function sukses(msg){
    Swal.fire({
        icon:'success',
        title:'Berhasil',
        text:msg
    });
}

function gagal(msg){
    Swal.fire({
        icon:'error',
        title:'Gagal',
        text:msg
    });
}
