w_id = null
c_id = null //CITY ID
call_id = null
glob_param = null;

$(document).ready(function () {
    $.ajax({
        url: '/system/scripts/WorkerLoader.php',
        method: 'POST',
        data: {},
        success: function (ans) {
            if (ans != 1)
                $('.worker-wrapper').html(ans)

        }
    })

    $(".close-mdl").click(function () {
        $(".overlay").fadeOut(600)
    })

    $(".close-mdl-swap").click(function () {
        $("#edit-city-brd").css("display", "none")
        $("#add-city-brd").css("display", "none")
        $("#cites-brd").css("display", "block")
    })

    $("#add-ab").click(function () {
        $("#call-brd").css("display", "none")
        $("#cites-brd").css("display", "none")
        $("#edit-ab-brd").css("display", "none")
        $("#edit-city-brd").css("display", "none")
        $("#add-city-brd").css("display", "none")
        $("#ed-call-brd").css("display", "none")

        $.ajax({
            url: "/system/scripts/GetCites.php",
            method: "POST",
            data: {},
            success: function (ans) {
                $('.noStagesMsg').remove()
                if (ans != 1) {
                    var ans_res = JSON.parse(ans);
                    console.log(ans_res);
                    $('.stgs-row').remove()



                    $.each(ans_res, function (i, item) {
                        $("#stages-add-tbl").append('<tr class="stgs-row"><td><input type="checkbox" name="p-stgs[]" value="' + item[0] + '"> <label for="p-stgs">' + item[1] + '</label></td> <td><input type="checkbox" name="r-stgs[]" value="' + item[0] + '"> <label for="r-stgs">' + item[1] + '</label></td></tr>')
                    })
                } else {
                    $("#add-ab-frm-btn").before('<div class = "noStagesMsg">Разделы не найдены</div>')
                }
            }
        })

        $("#ab-brd").css("display", "block")
        $(".overlay").fadeIn(600)
    })

    $("#add-call").click(function () {
        if (w_id == null)
            return
        $.ajax({
            url: "/system/scripts/GetCites.php",
            method: "POST",
            success: function (ans) {
                if (ans != 1) {
                    var ans_res = JSON.parse(ans);
                    console.log(ans_res);
                    $("#call-add-frm-sel").empty()

                    $("#call-add-frm-sel").append($("<option>", {
                        value: -1,
                        text: "Звонил в"
                    }))

                    $.each(ans_res, function (i, item) {
                        $("#call-add-frm-sel").append($("<option>", {
                            value: item[0],
                            text: item[1] + " (" + item[2] + ")"
                        }))
                    })
                }

            }
        })

        $("#ab-brd").css("display", "none")
        $("#edit-ab-brd").css("display", "none")
        $("#cites-brd").css("display", "none")
        $("#edit-city-brd").css("display", "none")
        $("#add-city-brd").css("display", "none")
        $("#ed-call-brd").css("display", "none")
        $("#call-brd").css("display", "block")
        $(".overlay").fadeIn(600)
    })

    $("#call-add-frm-btn").click(function () {
        if (c_id == null)
            return

        call_in = $("#call-add-frm-sel").val().trim()
        tarif = $("#tarif-call-add").val().trim()
        date_time = $("#date-time-add-call").val().trim()
        duration = $("#dur").val().trim()

        $.ajax({
            url: "/system/scripts/AddWorkerCall.php",
            method: "POST",
            data: { ab_id: w_id, call_in: call_in, tarif: tarif, date_time: date_time, duration: duration },
            success: function (ans) {
                if (ans == "") {
                    GetWorkerCalls(w_id)
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }
            }
        })
    })

    $('.date_time').datetimepicker({
        mask: true,
        format: "d.m.Y"
    });

    $("#add-ab-frm-btn").click(function () {
        shifr = $("#shifr").val().trim()
        gip = $("#gip").val().trim()
        zakazchik = $("#zakaz").val().trim()
        coast = $("#cost").val().trim()
        dog_code = $("#dog-code").val().trim()
        obj_type = $("#obj-type").val()
        obj_status = $("#obj-status").val()
        date_start = $("#date-start").val()
        date_end = $("#date-end").val()
        p_stages = new Array();
        r_stages = new Array();
        $("input[name='p-stgs[]']:checked").each(function () {
            p_stages.push($(this).val());
        });

        $("input[name='r-stgs[]']:checked").each(function () {
            r_stages.push($(this).val());
        });


        $.ajax({
            url: "/system/scripts/AddWorkerPersonal.php",
            method: "POST",
            data: { shifr: shifr, gip: gip, zakazchik: zakazchik, coast: coast, dog_code: dog_code, obj_type: obj_type, obj_status: obj_status, date_start: date_start, date_end: date_end, p_stages: p_stages, r_stages: r_stages },
            success: function (ans) {
                console.log(ans)
                if (ans == "") {
                    $.post('/system/scripts/WorkerLoader.php', function (ans) {
                        if (ans != 1){
                            $('.worker-wrapper').html(ans)
                            $("#shifr").val("")
                            $("#gip").val("")
                            $("#zakaz").val("")
                            $("#cost").val("")
                            $("#dog-code").val("")
                            $("#obj-type").val("")
                            $("#obj-status").val("")
                            $("#date-start").val("")
                            $("#date-end").val("")
                        }
                        else {
                            $('.err-container').html('возникла ошибка при загрузке списка объектов')
                            $('.err-container').fadeIn(700)
                            $('.err-container').fadeOut(3000)
                        }
                    })
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }
            }
        })
    })

    $("#del-ab").click(function () {
        if (!confirm("Вы уверенны?"))
            return

        if (w_id == null) {
            $('.err-container').html('возникла ошибка при удалении объекта')
            $('.err-container').fadeIn(700)
            $('.err-container').fadeOut(3000)
            return
        }
        $(".toDel").remove()
        $.ajax({
            url: "/system/scripts/DelWorker.php",
            method: "POST",
            data: { project_id: w_id },
            success: function (ans) {
                if (ans == 0) {
                    $.post('/system/scripts/WorkerLoader.php', function (ans) {
                        if (ans != 1)
                            $('.worker-wrapper').html(ans)
                        else {
                            $('.err-container').html('возникла ошибка при загрузке списка объектов')
                            $('.err-container').fadeIn(700)
                            $('.err-container').fadeOut(3000)
                        }
                    })
                    $("#GIP").html("")
                    $("#Buyer").html("")
                    $("#Coast").html("")
                    $("#dog_code").html("")
                    $("#obj_type").html("")
                    $("#date_start").html("")
                    $("#date_end").html("")
                    w_id = null
                }
            }
        })
    })

    $("#edit-ab").click(function () {
        if (w_id == null) {
            $('.err-container').html('Вначале выберите объект')
            $('.err-container').fadeIn(700)
            $('.err-container').fadeOut(3000)
            return
        }

        $.ajax({
            url: "/system/scripts/GetWorkerInfo.php",
            method: "POST",
            data: { proj_id: w_id },
            success: function (ans) {
                if (ans != 1) {
                    var ans_res = JSON.parse(ans)
                    $("#ed-shifr").val(ans_res[0])
                    $("#ed-gip").val(ans_res[1])
                    $("#ed-zakaz").val(ans_res[2])
                    $("#ed-cost").val(ans_res[3])
                    $("#ed-dog-code").val(ans_res[4])
                    $('#ed-obj-type option[value=' + ans_res[5] + ']').prop('selected', true);
                    $('#ed-obj-status option[value=' + ans_res[8] + ']').prop('selected', true);
                    $("#ed-date-start").val(ans_res[6])
                    $("#ed-date-end").val(ans_res[7])


                    $.ajax({
                        url: "/system/scripts/GetCites.php",
                        method: "POST",
                        data: {},
                        success: function (ans) {
                            $('.noStagesMsg').remove()
                            if (ans != 1) {
                                var ans_res = JSON.parse(ans);
                                console.log(ans_res);
                                $('.stgs-row').remove()

                                for (let i = 0; i < ans_res.length; i++) {
                                    const item = ans_res[i];
                                    $("#ed-stages-add-tbl").append('<tr class="stgs-row"><td><input type="checkbox" name="p-stgs[]" value="' + item[0] + '"> <label for="p-stgs">' + item[1] + '</label></td> <td><input type="checkbox" name="r-stgs[]" value="' + item[0] + '"> <label for="r-stgs">' + item[1] + '</label></td></tr>')
                                    for (let j = 0; j < $(".p-stage .toDel").length; j++) {
                                        if (item[0] == $("#pid-" + j).html())
                                            $("#ed-stages-add-tbl input[type='checkbox'][name='p-stgs[]']:last").prop("checked", true)
                                    }
                                    for (let k = 0; k < $(".r-stage .toDel").length; k++) {
                                        if (item[0] == $("#rid-" + k).html())
                                            $("#ed-stages-add-tbl input[type='checkbox'][name='r-stgs[]']:last").prop("checked", true)
                                    }
                                }
                            } else
                                $("#edit-ab-frm-btn").before('<div class = "noStagesMsg">Разделы не найдены</div>')
                        }
                    })

                    $("#call-brd").css("display", "none")
                    $("#ab-brd").css("display", "none")
                    $("#cites-brd").css("display", "none")
                    $("#edit-city-brd").css("display", "none")
                    $("#add-city-brd").css("display", "none")
                    $("#ed-call-brd").css("display", "none")
                    $("#edit-ab-brd").css("display", "block")
                    $(".overlay").fadeIn(600)
                }

                else {
                    $('.err-container').html('Не удалось получить данные по объекту')
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }
            }
        })
    })

    $("#edit-ab-frm-btn").click(function () {
        shifr = $("#ed-shifr").val().trim()
        gip = $("#ed-gip").val().trim()
        zakazchik = $("#ed-zakaz").val().trim()
        coast = $("#ed-cost").val().trim()
        dog_code = $("#ed-dog-code").val().trim()
        obj_type = $("#ed-obj-type").val()
        obj_status = $("#ed-obj-status").val()
        date_start = $("#ed-date-start").val()
        date_end = $("#ed-date-end").val()
        p_stages = new Array();
        r_stages = new Array();
        $("input[name='p-stgs[]']:checked").each(function () {
            p_stages.push($(this).val());
        });

        $("input[name='r-stgs[]']:checked").each(function () {
            r_stages.push($(this).val());
        });

        $.ajax({
            url: "/system/scripts/EditWorkerPersonal.php",
            method: "POST",
            data: { id: w_id, shifr: shifr, gip: gip, zakazchik: zakazchik, coast: coast, dog_code: dog_code, obj_type: obj_type, obj_status: obj_status, date_start: date_start, date_end: date_end, p_stages: p_stages, r_stages: r_stages },
            success: function (ans) {
                console.log(ans)
                if (ans == "") {
                    $("#GIP").html("")
                    $("#Buyer").html("")
                    $("#Coast").html("")
                    $("#dog_code").html("")
                    $("#obj_type").html("")
                    $("#date_start").html("")
                    $("#date_end").html("")
                    $(".toDel").remove()

                    $.post('/system/scripts/WorkerLoader.php', function (ans) {
                        if (ans != 1)
                            $('.worker-wrapper').html(ans)
                        else {
                            $('.err-container').html('возникла ошибка при загрузке списка объектов')
                            $('.err-container').fadeIn(700)
                            $('.err-container').fadeOut(3000)
                        }
                    })
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }
            }
        })
    })

    $(".search>input").on("input", function () {
        query = $(".search>input").val().trim()
        w_id = null

        $.ajax({
            url: "/system/scripts/search.php",
            method: "POST",
            data: { query: query },
            success: function (ans) {
                if (ans != 1) {
                    $('.worker-wrapper').empty()
                    $('.worker-wrapper').html(ans)
                }
                else {
                    $('.err-container').html('Не удалось ничего найти')
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }

            }
        })
    })

    $("#cites-main-btn").click(function () {
        GetCites()
        $("#ab-brd").css("display", "none")
        $("#edit-ab-brd").css("display", "none")
        $("#call-brd").css("display", "none")
        $("#edit-city-brd").css("display", "none")
        $("#add-city-brd").css("display", "none")
        $("#ed-call-brd").css("display", "none")
        $("#cites-brd").css("display", "block")
        $(".overlay").fadeIn(600)

    })

    $("#city-tarif").on("input", function () {
        $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
    })

    $("#city-tarif-ad").on("input", function () {
        $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
    })

    $("#edit-city-frm-btn").click(function () {
        stage_name = $("#city-name").val().trim()

        $.ajax({
            url: "/system/scripts/EditCity.php",
            method: "POST",
            data: { id: c_id, stage_name: stage_name },
            success: function (ans) {
                if (ans == "") {
                    GetCites()
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }

            }
        })
    })

    $("#add-city").click(function () {
        $("#ab-brd").css("display", "none")
        $("#edit-ab-brd").css("display", "none")
        $("#call-brd").css("display", "none")
        $("#cites-brd").css("display", "none")
        $("#edit-city-brd").css("display", "none")
        $("#ed-call-brd").css("display", "none")
        $("#add-city-brd").css("display", "block")
    })

    $("#city-add-frm-btn").click(function () {
        stage_name = $("#city-name-ad").val().trim()

        $.ajax({
            url: "/system/scripts/AddCity.php",
            method: "POST",
            data: { stage_name: stage_name },
            success: function (ans) {
                if (ans == "") {
                    GetCites()
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }
            }
        })
    })

    $("#call-add-frm-sel").change(function () {
        if ($(this).val() == -1)
            return
        c_id = $(this).val()

        $.ajax({
            url: "/system/scripts/GetCity.php",
            method: "POST",
            data: { city_id: c_id },
            success: function (ans) {
                if (ans != 1) {
                    var ans_res = JSON.parse(ans)
                    $("#tarif-call-add").val(ans_res[3])
                }
                else {
                    $('.err-container').html('Не удалось получить данные города')
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                    return
                }
            }
        })
    })

    $("#call-ed-frm-btn").click(function () {
        razrab = $("#ed-stg-razrab").val().trim()
        prov = $("#ed-stg-prov").val().trim()
        stat = $("#ed-stg-stat").val().trim()

        $.ajax({
            url: '/system/scripts/EditWorkerCall.php',
            method: 'POST',
            data: { id: call_id, razrab: razrab, prov: prov, stat: stat, p:glob_param },
            success: function (ans) {
                if (ans == "") {
                    GetWorkerCalls(w_id)
                    GetWorkerFio(w_id)
                }
                else {
                    $('.err-container').html(ans)
                    $('.err-container').fadeIn(700)
                    $('.err-container').fadeOut(3000)
                }

            }
        })

    })
})

function EditCallFrmShow(id, param) {
    call_id = id;
    glob_param = param

    if (w_id == null)
        return
    $.ajax({
        url: "/system/scripts/GetCall.php",
        method: "POST",
        data: { call_id: call_id, p: param },
        success: function (ans) {

            if (ans != 1) {
                var ans_res = JSON.parse(ans)
                console.log(ans_res)
                $("#ed-stg-razrab").val(ans_res[0])
                $("#ed-stg-prov").val(ans_res[1])
                $('#ed-stg-stat option[value=' + ans_res[2] + ']').prop('selected', true);
            }
            else {
                $('.err-container').html('Не удалось получить данные о звонке')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
                return
            }
        }
    })


    $("#ab-brd").css("display", "none")
    $("#edit-ab-brd").css("display", "none")
    $("#call-brd").css("display", "none")
    $("#cites-brd").css("display", "none")
    $("#edit-city-brd").css("display", "none")
    $("#add-city-brd").css("display", "none")
    $("#ed-call-brd").css("display", "block")
    $(".overlay").fadeIn(600)
}


function EditCityFromShow(id) {
    c_id = id

    $.ajax({
        url: "/system/scripts/GetCity.php",
        method: "POST",
        data: { stage_id: c_id },
        success: function (ans) {
            if (ans != 1) {
                $("#city-name").val("")
                var ans_res = JSON.parse(ans)
                $("#city-name").val(ans_res[1])
            }
            else {
                $('.err-container').html('Не удалось получить данные города')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
                return
            }
        }
    })

    $("#ab-brd").css("display", "none")
    $("#edit-ab-brd").css("display", "none")
    $("#call-brd").css("display", "none")
    $("#cites-brd").css("display", "none")
    $("#add-city-brd").css("display", "none")
    $("#ed-call-brd").css("display", "none")
    $("#edit-city-brd").css("display", "block")
}

function DelCall(id) {
    if (!confirm("Вы уверены?"))
        return

    $.ajax({
        url: '/system/scripts/DelCall.php',
        method: 'POST',
        data: { call_id: id },
        success: function (ans) {
            if (ans == 0) {
                GetWorkerCalls(w_id)
            }
            else {
                $('.err-container').html('Не удалось удалить звонок')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
            }
        }
    })

}

function DelCity(id) {
    if (!confirm("Вы уверены?"))
        return

    $.ajax({
        url: '/system/scripts/DelCity.php',
        method: 'POST',
        data: { stage_id: id },
        success: function (ans) {
            if (ans == 0) {
                GetCites()
            }
            else {
                $('.err-container').html('Не удалось удалить раздел')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
            }
        }
    })
}

function GetCites() {
    $.ajax({
        url: '/system/scripts/GetCites.php',
        method: 'POST',
        success: function (ans) {
            if (ans != 1) {
                var ans_res = JSON.parse(ans);
                console.log(ans_res);
                $("#cites-tbl>tbody").empty()

                $.each(ans_res, function (i, item) {
                    $("#cites-tbl>tbody").append("<tr> <td>" + item[0] + "</td> <td>" + item[1] + "</td> <td> <span class = 'del-city'> <img class='cntrl-ab-btns' width='20px' src='/system/styles/pics/del.png' alt='del' onclick = 'DelCity(" + item[0] + ")'> </span> <span><img class='cntrl-ab-btns' width='20px' src='/system/styles/pics/edit.png' alt='edit' onclick = 'EditCityFromShow(" + item[0] + ")'></span> </td></tr>")
                })
            }
            else
                $("#cites-tbl>tbody").empty()

        }
    })
}

function GetWorkerCalls(id) {
    $(".toDel").remove()
    $.ajax({
        url: '/system/scripts/GetWorkerCalls.php',
        method: 'POST',
        data: { project_id: id },
        success: function (ans) {
            if (ans != 1) {
                var ans_res = JSON.parse(ans);
                console.log(ans_res);

                $.each(ans_res, function (i, item) {
                    if (item[3] == 0)
                        item[3] = "<span style = 'color: red'>Закончен</span>"
                    else
                        item[3] = "<span style = 'color: green'>Разрабатывается</span>"
                    $(".p-stage").append("<tr class = 'toDel'> <td id = 'pid-" + i + "' style = 'display: none;'>" + item[4] + "</td> <td style = 'border-right: none;'>" + item[0] + "</td> <td>" + item[1] + "</td> <td>" + item[2] + "</td> <td>" + item[3] + "</td> <td style='text-align: center'><img width='20px' alt='edit' class='cntrl-ab-btns' onclick=EditCallFrmShow(" + item[5] + ","+0+") src='/system/styles/pics/edit.png'></td> </tr>")
                })
            }
            else {
                $('.err-container').html('Не удалось получить данные по объекту')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
            }
        }
    })
}

function ClickOnWorker(obj) {
    $(".worker").parent().css({ "border-bottom": "2px solid black" })
    $(obj).parent().css({ "border-bottom": "2px solid red" })

}


function GetWorkerFio(id) {
    $(".toDel").remove()
    $.ajax({
        url: '/system/scripts/GetWorkerFio.php',
        method: 'POST',
        data: { project_id: id },
        success: function (ans) {
            if (ans != 1) {
                var ans_res = JSON.parse(ans);
                console.log(ans_res);

                $.each(ans_res, function (i, item) {
                    if (item[3] == 0)
                        item[3] = "<span style = 'color: red'>Закончен</span>"
                    else
                        item[3] = "<span style = 'color: green'>Разрабатывается</span>"
                    $(".r-stage").append("<tr class = 'toDel'> <td id = 'rid-" + i + "' style = 'display: none;'>" + item[4] + "</td> <td style = 'border-right: none;'>" + item[0] + "</td> <td>" + item[1] + "</td> <td>" + item[2] + "</td> <td>" + item[3] + "</td> <td style='text-align: center'><img width='20px' alt='edit' class='cntrl-ab-btns' onclick=EditCallFrmShow(" + item[5] + ","+1+") src='/system/styles/pics/edit.png'></td> </tr>")
                })
            }
            else {
                $('.err-container').html('Не удалось получить данные по объекту')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)
            }
        }
    })
}

function GetWorkerData(id) {
    w_id = id
    $.ajax({
        url: '/system/scripts/GetWorkerInfo.php',
        method: 'POST',
        data: { proj_id: id },
        success: function (ans) {
            if (ans != 1) {
                var ans_res = JSON.parse(ans)
                $("#GIP").html(ans_res[1])
                $("#Buyer").html(ans_res[2])
                $("#Coast").html(ans_res[3])
                $("#dog_code").html(ans_res[4])

                switch (ans_res[5]) {
                    case '1':
                        $("#obj_type").html("Жилой")
                        break
                    case '2':
                        $("#obj_type").html("Промышленный")
                        break
                    case '3':
                        $("#obj_type").html("Общественный")
                        break
                }

                $("#date_start").html(ans_res[6])
                $("#date_end").html(ans_res[7])

            }

            else {
                $("#adress").html("")
                $("#pho").html("")
                $("#passport").html("")
                $("#call_in").html("")
                $("#coast").html("")
                $("#dtocall").html("")
                $("#dur").html("")
                $("#total").html("")

                $('.err-container').html('возникла ошибка при загрузке данных объекта')
                $('.err-container').fadeIn(700)
                $('.err-container').fadeOut(3000)

            }
        }
    })
}