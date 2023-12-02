const flashdata = $('.flash-data').data('flashdata');
const title = $('.flash-data').attr('title');

if (flashdata) {
    Swal.fire({
        title: 'Data ' + title,
        text: 'Berhasil ' + flashdata,
        icon: 'success'
    });
}

$('.hapus').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: `data ${title} akan dihapus`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Data!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href;
        }
    });
});