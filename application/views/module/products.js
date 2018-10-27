$.ajax({
    url: `${base_url}product/get_all_products`,
    type: "GET",
    dataType: "JSON",
    beforeSend() {
        UIkit.modal("#loader").show()
    },
    success(data) {
        if (data.length > 0) {
            data.forEach(v => {
                let temp = $(".iTemp").clone().removeClass("iTemp").show()
                $(".iName", temp).text(v.product_name)
                $(".iMonitor", temp).attr("href", `${base_url}product/index/${v.product_id}`)
                $(".iLazada", temp).attr("href", v.product_url)
                $("tbody").append(temp)
            });
        }
        UIkit.modal("#loader").hide()

        $("#products").DataTable()
    },
    error(ret) {
        console.log(ret.toString())
    }
})