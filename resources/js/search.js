document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector('input[name="search_product"]');
    const scanButton = document.querySelector(".scan-button");
    const myFileInput = document.getElementById("myFile");
    // const imgPreview = document.getElementById("imgpreview");
    const submitImageBtn = document.getElementById("submitImage");
    console.log("scanButton:", scanButton);
    console.log("myFileInput:", myFileInput);
    console.log("imgPreview:", imgPreview);
    console.log("submitImageBtn:", submitImageBtn);
    document.querySelectorAll(".scan-button").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(
                document.getElementById("scanModal")
            );
            modal.show();
        });
    });
    function performSearch(searchTerm) {
        if (searchTerm) {
            const url = new URL(window.location.href);
            url.searchParams.set("search", searchTerm);
            window.location.href = url.toString();
        }
    }

    // Xử lý khi chọn file
    myFileInput.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // imgPreview.querySelector("img").src = e.target.result;
                // imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });

    // Xử lý khi nhấn nút xác nhận
    submitImageBtn.addEventListener("click", function () {
        const file = myFileInput.files[0];
        if (file) {
            const formData = new FormData();
            formData.append("image", file);

            fetch("http://127.0.0.1:5000/predict", {
                // Thay bằng endpoint của bạn
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.result) {
                        searchInput.value = data.result;
                        performSearch(data.result);
                        $("#scanModal").modal("hide"); // Đóng modal
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    });
});
