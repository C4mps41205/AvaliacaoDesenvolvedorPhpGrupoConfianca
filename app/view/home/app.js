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

    Read();
    $("#buttonSearch").click(() => Read());
    $("#Update").click(() => Update());
    $("#createNew").click(() => Insert());
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

const Insert = async () =>
{
    if(($("#nameCreate").val() == undefined || $("#nameCreate").val() == '') || 
       ($("#itrCreate").val() == undefined || $("#itrCreate").val() == '') || 
       ($("#birthdateCreate").val() == undefined || $("#birthdateCreate").val() == '') ||
       $("#stateCreate").val() == '')
    {
        Swal.fire("Atenção", "Preencha os campos obrigatórios", "warning");
        return;
    }

    if( ($("#itrCreate").val().length < 14 && $("#itrCreate").val().length > 0) || 
        ($("#birthdateCreate").val().length < 10 && $("#birthdateCreate").val().length > 0) ||
        ($("#phoneCreate").val().length < 14 && $("#phoneCreate").val().length > 0))
    {
        Swal.fire("Atenção", "Os campos que contêm mascara são necessários o preenchimento total deles ou deixa-los vazios", "warning");
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
        if (result.isConfirmed) 
        {
            const requestData = 
            {
                "type": "post",
                "url": "/index/delete/" + id,
                "data": {}
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
        }
    });
}

const Update = async () =>
{
    if($("#idUserUpdate").val() == undefined || $("#idUserUpdate").val() == null)
    {
        Swal.fire("Atenção", "Algo deu errado. Recarregue a página", "error");
        return
    }

    if( ($("#itrUpdate").val().length < 14 && $("#itrUpdate").val().length > 0) || 
        ($("#birthdateUpdate").val().length < 10 && $("#birthdateUpdate").val().length > 0) ||
        ($("#phoneUpdate").val().length < 14 && $("#phoneUpdate").val().length > 0))
        {
            Swal.fire("Atenção", "Os campos que contêm mascara são necessários o preenchimento total deles ou deixa-los vazios", "warning");
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