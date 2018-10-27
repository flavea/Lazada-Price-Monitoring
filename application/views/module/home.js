let home = {
    init: function() {
        $("#submit").click(() => {
            this.Validate()
        })
    },
    Validate: function() {
        let url = $("#URL").val()
        try {
            new URL(url);

            if (url === "" || url == null || url == undefined) {
                UIkit.modal.alert('URL must be filled!')
                $("#URL").addClass("uk-form-danger")
            } else if (url.indexOf("lazada.co.id") === -1) {
                UIkit.modal.alert('URL must be from lazada.co.id!')
                $("#URL").addClass("uk-form-danger")
            } else
                this.AddLink(url)
        } catch (ex) {
            console.log(ex);
            UIkit.modal.alert('URL is not in the right format!')
        }
    },
    AddLink: function(url) {
        let data = {
            url: url
        }

        $.ajax({
            url: `${base_url}product/add_new_product`,
            data,
            type: "POST",
            dataType: "JSON",
            beforeSend() {
                UIkit.modal("#loader").show()
            },
            success(ret) {
                if (ret.id > 0) window.location.href = `${base_url}product/index/${ret.id}`
                else UIkit.modal.alert("A product with this link does not exist. Please try again.")
            },
            error(ret) {
                console.log(ret)
            }
        })
    }
}

home.init()