const flashdata = $(".flash-data").data("flashdata");
const title = $(".flash-data").attr("title");

if (flashdata) {
	Swal.fire({
		title: "Data " + title,
		text: "Berhasil " + flashdata,
		icon: "success",
	});
}

const lapangan = $(".lapangan").data("flashdata");
const titleLapangan = $(".lapangan").attr("title");

if (lapangan) {
	Swal.fire({
		title: titleLapangan,
		text: lapangan,
		icon: "warning",
	});
}

const jam = $(".jam").data("flashdata");
const jamTitle = $(".jam").attr("title");

if (jam) {
	Swal.fire({
		title: jamTitle,
		text: jam,
		icon: "warning",
	});
}

$(".hapus").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");
	Swal.fire({
		title: "Apakah anda yakin?",
		text: `Data ${title} akan dihapus`,
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus Data!",
	}).then((result) => {
		if (result.isConfirmed) {
			document.location.href = href;
		}
	});
});
