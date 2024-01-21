$(document).ready(() => 
{
    Read();
    $("#buttonSearch").click(() => Read());
   
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

const Insert = () =>
{

}

const Read = async () => 
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

    data.response.forEach(eachData => 
    {
        table +=
        ` 
            <tr>
                <td style="text-align: center">${eachData.name == undefined ? "" : eachData.name}</td>
                <td style="text-align: center">${eachData.itr == undefined ? "" : eachData.itr}</td>
                <td style="text-align: center">${eachData.birthdate == undefined ? "" : eachData.birthdate}</td>
                <td style="text-align: center">${eachData.state == undefined ? "" : eachData.state}</td>
                <td style="text-align: center">${eachData.city == undefined ? "" : eachData.city}</td>
                <td style="text-align: center">${eachData.neighborhood == undefined ? "" : eachData.neighborhood}</td>
                <td style="text-align: center">${eachData.phone == undefined ? "" : eachData.phone}</td>
                <td style="text-align: center">${eachData.email == undefined ? "" : eachData.email}</td>
                <td style="text-align: center">
                    <button class="btn btn-success btn-xs" title="Clique aqui para exibir esse usuário" onclick="ReadById(${requestData.id})" data-toggle="modal" data-target="#EditModal"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-danger btn-xs"  title="Clique aqui para deletar esse usuário" onclick="Delete(${requestData.id})"><i class="fa-solid fa-trash"></i></button>
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
}

const ReadById = (id) =>
{

}

const Delete = (id) =>
{

}

const Update = () =>
{

}