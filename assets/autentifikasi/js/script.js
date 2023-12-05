const pesan = $(".pesan").data("flashdata");
const titlePesan = $(".pesan").attr("title");

if (pesan) {
	Swal.fire({
		title: titlePesan,
		text: pesan,
		icon: "warning",
	});
}

const logout = $(".pesan-logout").data("flashdata");
const titleLogout = $(".pesan-logout").attr("title");

if (logout) {
	Swal.fire({
		title: titleLogout,
		text: logout,
		icon: "success",
	});
}
