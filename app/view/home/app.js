$(document).ready(() => 
{
    $("#itrSelect").mask('000.000.000-00');
    $("#itrUpdate").mask('000.000.000-00');
    $("#itrCreate").mask('000.000.000-00');

    $("#birthdateSelect").mask('00/00/0000');
    $("#birthdateUpdate").mask('00/00/0000');
    $("#birthdateCreate").mask('00/00/0000');
    
    $("#phoneSelect").mask('(00)00000-0000');
    $("#phoneUpdate").mask('(00)00000-0000');
    $("#phoneCreate").mask('(00)00000-0000');

    $("#buttonSearch").click(() => Read());
    $("#Update").click(() => Update());
    $("#createNew").click(() => Insert());

    Read();
})
const AjaxRequest = async (params = {}) => 
{
    return new Promise((resolve, reject) => 
    {
        $.ajax
        ({
            type: params.type,
            url: params.url,
            dataType: 'json',
            data: params.data,
            success: (data) => 
            {
                resolve(data);
            },
            error: (error) => 
            {
                reject(error);
            }
        });
    });
};

const CheckEmail = (inputId) =>
{
    if($(`#${inputId}`).val().length == 0)
    {
        return true;
    }

    if($(`#${inputId}`).val().indexOf('@') == -1)
    {
        Swal.fire("Atenção", "Escreva um e-mail válido", "warning");
        return false;
    }

    return true;
}

const CheckInputs = (type) =>
{
    if(( $(`#name${type}`).val() == undefined || $(`#name${type}`).val() == '') || 
        ($(`#itr${type}`).val() == undefined || $(`#itr${type}`).val() == '') || 
        ($(`#birthdate${type}`).val() == undefined || $(`#birthdate${type}`).val() == '') ||
        $(`#state${type}`).val() == '')
    {
        Swal.fire("Atenção", "Preencha os campos obrigatórios", "warning");
        return false;
    }

    if( ($(`#itr${type}`).val().length < 14 && $(`#itr${type}`).val().length > 0) || 
        ($(`#birthdate${type}`).val().length < 10 && $(`#birthdate${type}`).val().length > 0) ||
        ($(`#phone${type}`).val().length < 14 && $(`#phone${type}`).val().length > 0))
    {
        Swal.fire("Atenção", "Os campos que contêm mascara são necessários o preenchimento total deles", "warning");
        return false;
    }

    return true;
}

const Insert = async () =>
{
    let requiredInputs = CheckInputs("Create");
    let emailinput = CheckEmail("emailCreate");

    if(!emailinput || !requiredInputs)
    {
        return;
    }

    const requestData = 
    {
        "type": "post",
        "url": "/index/create",
        "data": 
        {
            "name" : $("#nameCreate").val(),
            "itr": $("#itrCreate").val(),
            "birthdate": $("#birthdateCreate").val(),
            "state": $("#stateCreate").val(), 
            "city": $("#cityCreate").val(),
            "neighborhood": $("#neighborhoodCreate").val(),
            "phone": $("#phoneCreate").val(),
            "email": $("#emailCreate").val()
        }
    };
    var data = await AjaxRequest(requestData);

    if(data.status != 500 && data.response != "success")
    {
        Swal.fire("Atenção", "Algo deu errado.", "error");
        return;
    }

    Swal.fire("Sucesso", "Usuário cadastrado com sucesso!", "success");
    
    $("#CreateModal").modal("hide");
    
    $("#CreateModal").modal('hide');
    await Read();
    return;
}

const Read = async () => 
{
    const requestData = 
    {
        "type": "post",
        "url": "/index/select",
        "data": 
        {
            "name" : $("#nameSelect").val(),
            "itr": $("#itrSelect").val(),
            "birthdate": $("#birthdateSelect").val(),
            "state": $("#stateSelect").val(), 
            "city": $("#citySelect").val(),
            "neighborhood": $("#neighborhoodSelect").val(),
            "phone": $("#phoneSelect").val(),
            "email": $("#emailSelect").val()
        }
    };
    var data = await AjaxRequest(requestData);
    
    CreateTable(data.response);
    return;
}

const CreateTable = (data) =>
{
    var table = 
    `
    <table class="table table-striped" id="table">
        <thead>
            <tr>
                <td style="text-align: center">Nome</td>
                <td style="text-align: center">CPF</td>
                <td style="text-align: center">data de aniversário</td>
                <td style="text-align: center">Estado</td>
                <td style="text-align: center">Cidade</td>
                <td style="text-align: center">Bairro</td>
                <td style="text-align: center">Celular</td>
                <td style="text-align: center">Email</td>
                <td style="text-align: center">Ações</td>
            </tr>
        </thead>
        <tbody>
    `;
    data.forEach(eachData => 
        {
            table +=
            ` 
                <tr>
                    <td style="text-align: center">${eachData.name == undefined ? "" : eachData.name}</td>
                    <td style="text-align: center">${eachData.itr == undefined ? "" : eachData.itr}</td>
                    <td style="text-align: center">${eachData.birthdate == undefined ? "" : eachData.birthdate}</td>
                    <td style="text-align: center">${eachData.nameState == undefined ? "" : eachData.nameState}</td>
                    <td style="text-align: center">${eachData.city == undefined ? "" : eachData.city}</td>
                    <td style="text-align: center">${eachData.neighborhood == undefined ? "" : eachData.neighborhood}</td>
                    <td style="text-align: center">${eachData.phone == undefined ? "" : eachData.phone}</td>
                    <td style="text-align: center">${eachData.email == undefined ? "" : eachData.email}</td>
                    <td style="text-align: center">
                        <button class="btn btn-success btn-xs" title="Clique aqui para exibir esse usuário" onclick="ReadById(${eachData.idClient})" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-danger btn-xs"  title="Clique aqui para deletar esse usuário" onclick="Delete(${eachData.idClient})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `
        });
    
        table += 
        `
            </tbody>
        </table>
        `;
    
        $("#tableDiv").html(table);
        return;
}

const ReadById = async (id) =>
{
    const requestData = 
    {
        "type": "post",
        "url": "/index/select",
        "data": 
        {
            "idClient" : id,
        }
    };

    var data = await AjaxRequest(requestData);
    const dataUser = data.response[0];

    $("#idUserUpdate").val(dataUser.idClient);
    $("#nameUpdate").val(dataUser.name);
    $("#itrUpdate").val(dataUser.itr);
    $("#birthdateUpdate").val(dataUser.birthdate);
    $("#stateUpdate").val(dataUser.id); 
    $("#cityUpdate").val(dataUser.city);
    $("#neighborhoodUpdate").val(dataUser.neighborhood);
    $("#phoneUpdate").val(dataUser.phone);
    $("#emailUpdate").val(dataUser.email);  
}

const Delete = async (id) =>
{
    Swal.fire
    ({
        title: "Atenção",
        icon: "warning",
        text: "Você deseja excluir esse usuário?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Sim",
        denyButtonText: "Não"
    }).then(async (result) => 
      {
        if (result.dismiss) 
        {
            return;
        }

        const requestData = 
        {
            "type": "post",
            "url": "/index/delete/" + id,
            "data": 
            {
                "delete" : true
            }
        };

        var data = await AjaxRequest(requestData);

        if(data.status === 200 && data.response === "success")
        {
            Swal.fire("Sucesso", "Usuário excuido com êxito!", "success");
            await Read();
            return;
        }

        Swal.fire("Atenção", "Algo deu errado", "error");
        return;
        
    });
}

const Update = async () =>
{
    let requiredInputs = CheckInputs("Update");
    let emailinput = CheckEmail("emailUpdate");

    if(!emailinput || !requiredInputs)
    {
        return;
    }

    const requestData = 
    {
        "type": "post",
        "url": "/index/update",
        "data": 
        {
            "idClient" : $("#idUserUpdate").val(),
            "name" : $("#nameUpdate").val(),
            "itr": $("#itrUpdate").val(),
            "birthdate": $("#birthdateUpdate").val(),
            "state": $("#stateUpdate").val(), 
            "city": $("#cityUpdate").val(),
            "neighborhood": $("#neighborhoodUpdate").val(),
            "phone": $("#phoneUpdate").val(),
            "email": $("#emailUpdate").val()
        }
    };
    var data = await AjaxRequest(requestData);

    if(data.status != 200 && data.response != "success")
    {
        Swal.fire("Atenção", "Algo deu errado.", "error");
        return;
    }

    $("#EditModal").modal('hide');
    Swal.fire("Sucesso!", "Usuário alterado com êxito!", "success");
    await Read();
    return;
}