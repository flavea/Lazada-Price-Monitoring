let view;
let product = {
    productID: "",
    Prices: [],
    Comments: [],
    currComment: "",
    init() {
        view = this
        view.productID = window.location.href.split("/").pop()
        $(document).on('click', '.btnComment', e => {
            if ($(e.currentTarget).parent().parent().hasClass("main-box")) {
                view.currComment = ""
                $('.reply-box').remove()
            }
            view.validateComment($(e.currentTarget))
        })

        $(document).on('click', '.upvote', e => {
            view.currComment = $(e.currentTarget).attr("comment_id")
            view.upvote(e.currentTarget)
        })

        $(document).on('click', '.downvote', e => {
            view.currComment = $(e.currentTarget).attr("comment_id")
            view.downvote(e.currentTarget)
        })

        $(document).on('click', '.removeUpvote', e => {
            view.currComment = $(e.currentTarget).attr("comment_id")
            view.removeUpvote(e.currentTarget)
        })

        $(document).on('click', '.removeDownvote', e => {
            view.currComment = $(e.currentTarget).attr("comment_id")
            view.removeDownvote(e.currentTarget)
        })

        $(document).on('click', '.reply', e => {
            view.currComment = $(e.currentTarget).attr("comment_id")
            $('.reply-box').remove()
            let cb = $("#comment-box").clone().removeClass("main-box").addClass('reply-box')
            $(`#comment-${view.currComment} > ul`).before(cb)
        })

        setInterval(view.getData(), 1000 * 60 * 60)
    },
    getData(update = "") {
        //to get and scrap new data from the website
        $.ajax({
            url: `${base_url}product/get_data/${view.productID}`,
            type: "GET",
            dataType: "JSON",
            beforeSend() {
                $('#images, #smallList tbody, #bigList tbody, #comments').empty()
                $("#pageLoader").show()
                $(".uk-container").hide()
            },
            success(data) {
                if (typeof data.product_data.url !== "undefined") {
                    $("#productName").text(data.product_data.title);
                    $("#productPrice").text(data.product_data.price);
                    $("#productDescription").html(data.product_data.description);
                    $("#productDescription img").remove()
                    $("#productLink").attr("href", data.product_data.url);

                    data.product_data.images.forEach(i => {
                        let temp = $(".sliderTemp").clone().removeClass("sliderTemp").show()
                        $('a', temp).attr("href", i.src)
                        $('img', temp).attr("src", i.src)
                        $('#images').append(temp)
                    });

                    let leftImages = 5 - (data.product_data.images.length % 5)

                    if (leftImages != 5) {
                        for (let i = 0; i < leftImages; i++) {
                            let temp = $(".sliderTemp").clone().removeClass("sliderTemp").show()
                            $('a', temp).remove()
                            $('img', temp).remove()
                            $('#images').append(temp)
                        }
                    }

                    let smallData = data.product_prices.reverse().slice(0, 5)

                    smallData.forEach(p => {
                        let temp = $(".pTemp").clone().removeClass("pTemp")
                        $('.iDate', temp).text(p.created_at)
                        $('.iPrice', temp).text(`Rp ${p.price}`)
                        $('#smallList tbody').append(temp)
                    })

                    data.product_prices.forEach(p => {
                        let temp = $(".pTemp").clone().removeClass("pTemp")
                        $('.iDate', temp).text(p.created_at)
                        $('.iPrice', temp).text(`Rp ${p.price}`)
                        $('#bigList tbody').append(temp)
                    })

                    let leftPrices = 5 - (smallData.length % 5)

                    if (leftPrices != 5) {
                        for (let i = 0; i < leftPrices; i++) {
                            let temp = $(".pTemp").clone().removeClass("pTemp")
                            $('.iDate', temp).text("-")
                            $('.iPrice', temp).text("-")
                            $('#smallList tbody').append(temp)
                        }
                    }

                    view.createChart(smallData, "smallChart")
                    view.createChart(data.product_prices, "bigChart")

                    $("#pageLoader").hide()
                    $(".uk-container").show()

                    view.loadComments()
                } else {
                    UIkit.modal.alert("This product does not exist or has been deleted.").then(() => {
                        window.location.href = base_url
                    });
                }
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    createChart(history, chart) {
        history.reverse()
        let labels = history.map(l => l.created_at)
        let prices = history.map(l => l.price)
        let ctx = document.getElementById(chart).getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Price in Rupiah',
                    data: prices,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    },
    loadComments() {
        $.ajax({
            url: `${base_url}comment/get_comments/${view.productID}`,
            type: "GET",
            dataType: "JSON",
            beforeSend() {
                $("#comments").empty()
                $("#commentLoader").show()
            },
            success(data) {
                if (data.length > 0) {
                    data = data.sort((a, b) => { return b.score - a.score });
                    view.Comments = data
                    data.forEach(v => {
                        let temp = view.processComment(v)
                        $("#comments").append(temp)
                        view.loadChildrenComments(v.comment_id)
                    })
                }
                $("#commentLoader").hide()
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    loadChildrenComments(comment_id) {
        $.ajax({
            url: `${base_url}comment/get_comment_children/${comment_id}`,
            type: "GET",
            dataType: "JSON",
            beforeSend() {
                $("#commentLoader").show()
            },
            success(data) {
                if (data.length > 0) {
                    data.sort((a, b) => { return a.score - b.score });
                    data.forEach(v => {
                        view.Comments.push(v)
                        let temp = view.processComment(v)
                        $(`#comment-${comment_id} ul`).append(temp)
                        view.loadChildrenComments(v.comment_id)
                    })
                }
                $("#commentLoader").hide()
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    processComment(v) {
        let temp = $('.iComment').clone().removeClass("iComment").show().attr("id", `comment-${v.comment_id}`)
        $('.uk-comment-title', temp).text(v.name)
        $('.upvote-number', temp).text(v.upvotes)
        $('.downvote-number', temp).text(v.downvotes)
        $('.uk-comment-body', temp).html(v.comment)
        $('.upvote, .downvote, .reply', temp).attr("comment_id", v.comment_id)
        if (v.own_upvote > 0) $('.upvote', temp).addClass("uk-alert-success").addClass('removeUpvote').removeClass('upvote')
        if (v.own_downvote > 0) $('.downvote', temp).addClass("uk-alert-danger").addClass('removeDownvote').removeClass('downvote')
        return temp
    },
    validateComment(target) {
        let alias, comment = ""
        if (view.currComment == "") {
            alias = $(".main-box #alias")
            comment = $(".main-box #comment")
        } else if (view.currComment != "") {
            alias = $(`#comment-${view.currComment} #alias`)
            comment = $(`#comment-${view.currComment} #comment`)
        }

        if (alias.val() === "") {
            UIkit.modal.alert('Please use an alias')
            alias.addClass("uk-form-danger")
        } else if (alias.val().length > 100) {
            UIkit.modal.alert('Alias can not have more than 100 characters')
            alias.addClass("uk-form-danger")
        } else if (comment.val() === "") {
            UIkit.modal.alert('Please write a comment before submitting it.')
            comment.addClass("uk-form-danger")
        } else view.submitComment(target)
    },
    submitComment(target) {
        let append, url, comment, alias = ""

        if (view.currComment === "") {
            alias = $(".main-box #alias")
            comment = $(".main-box #comment")
            url = `${base_url}comment/add_comment`
            append = $("#comments")
        } else {
            alias = $(`#comment-${view.currComment} #alias`)
            comment = $(`#comment-${view.currComment} #comment`)
            url = `${base_url}comment/reply_comment`
            append = $(`#comment-${view.currComment} ul`)
        }

        let data = {
            parent_id: view.currComment,
            product_id: view.productID,
            alias: alias.val(),
            comment: comment.val()
        }

        $.ajax({
            url: url,
            data,
            type: "POST",
            dataType: "JSON",
            beforeSend() {
                alias.attr("disabled", true)
                comment.attr("disabled", true)
                target.hide()
            },
            success(ret) {
                alias.removeClass("uk-form-danger").val("")
                comment.removeClass("uk-form-danger").val("")

                data.comment_id = ret.id
                data.name = data.alias
                data.downvotes = 0
                data.upvotes = 0
                data.own_downvote = 0
                data.own_upvote = 0

                view.Comments.push(data)
                let temp = view.processComment(data)
                append.prepend(temp)
                $('.reply-box').remove()
                view.currComment = ""

                alias.attr("disabled", false)
                comment.attr("disabled", false)
                target.show()
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    upvote(target) {
        let data = {
            comment_id: view.currComment
        }

        $.ajax({
            url: `${base_url}comment/upvote`,
            data,
            type: "POST",
            dataType: "JSON",
            success(ret) {
                if (ret.id > 0) {
                    let idx = view.Comments.findIndex(x => x.comment_id == view.currComment)
                    let currUpvote = view.Comments.find(x => x.comment_id == view.currComment).upvotes
                    let newUpvote = currUpvote + 1
                    $(`.upvote[comment_id=${view.currComment}]`).next().text(newUpvote)
                    view.currComment = ""
                    view.Comments[idx].upvotes = newUpvote
                    view.Comments[idx].own_upvote = 1
                    $(target).addClass("uk-alert-success").addClass('removeUpvote').removeClass('upvote')
                } else if (ret.id == -1) UIkit.modal.alert("You have upvoted this.")
                else if (ret.id == -2) UIkit.modal.alert("You downvoted this comment, you can only upvote or downvote.")
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    removeUpvote(target) {
        let data = {
            comment_id: view.currComment
        }

        $.ajax({
            url: `${base_url}comment/delete_upvote`,
            data,
            type: "POST",
            dataType: "JSON",
            success(ret) {
                if (ret.id == true) {
                    let idx = view.Comments.findIndex(x => x.comment_id == view.currComment)
                    let currUpvote = view.Comments.find(x => x.comment_id == view.currComment).upvotes
                    let newUpvote = currUpvote - 1
                    $(`.removeUpvote[comment_id=${view.currComment}]`).next().text(newUpvote)
                    view.Comments[idx].upvotes = newUpvote
                    view.currComment = ""
                    view.Comments[idx].own_upvote = 0
                    $(target).removeClass("uk-alert-success").removeClass('removeUpvote').addClass('upvote')
                }
            },
            error(ret) {
                console.log(ret)
            }
        })

    },
    downvote(target) {
        let data = {
            comment_id: view.currComment
        }

        $.ajax({
            url: `${base_url}comment/downvote`,
            data,
            type: "POST",
            dataType: "JSON",
            success(ret) {
                if (ret.id > 0) {
                    let idx = view.Comments.findIndex(x => x.comment_id == view.currComment)
                    let currDownvote = view.Comments.find(x => x.comment_id == view.currComment).downvotes
                    let newDownvote = currDownvote + 1
                    $(`.downvote[comment_id=${view.currComment}]`).next().text(newDownvote)
                    view.currComment = ""
                    view.Comments[idx].downvotes = newDownvote
                    view.Comments[idx].own_downvote = 1
                    $(target).addClass("uk-alert-danger").addClass('removeDownvote').removeClass('downvote')
                } else if (ret.id == -1) UIkit.modal.alert("You have downvoted this.")
                else if (ret.id == -2) UIkit.modal.alert("You upvoted this comment, you can only upvote or downvote.")
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
    removeDownvote(target) {
        let data = {
            comment_id: view.currComment
        }

        $.ajax({
            url: `${base_url}comment/delete_downvote`,
            data,
            type: "POST",
            dataType: "JSON",
            success(ret) {
                if (ret.id == true) {
                    let idx = view.Comments.findIndex(x => x.comment_id == view.currComment)
                    let currDownvote = view.Comments.find(x => x.comment_id == view.currComment).downvotes
                    let newDownvote = currDownvote - 1
                    $(`.removeDownvote[comment_id=${view.currComment}]`).next().text(newDownvote)
                    view.currComment = ""
                    view.Comments[idx].downvotes = newDownvote
                    view.Comments[idx].own_downvote = 0
                    $(target).removeClass("uk-alert-danger").removeClass('removeDownvote').addClass('downvote')
                }
            },
            error(ret) {
                console.log(ret)
            }
        })
    },
}

product.init()