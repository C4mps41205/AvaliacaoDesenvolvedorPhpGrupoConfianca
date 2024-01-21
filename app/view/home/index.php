<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Confiança - Cadastro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <form id="formFilter" method="get">
            <div class="accordion" id="accordion">
                <div class="card">
                    <div class="card-header" id="collapseFilter">
                        <div class="row">
                            <div class="col">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#mainInfos" aria-expanded="false" aria-controls="mainInfos">
                                        <i class="fa-solid fa-eye-slash"></i> Esconder filtros
                                    </button>
                                </h5>
                            </div>

                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="buttonSearch" class="btn btn-secondary"><i
                                                class="fa-solid fa-magnifying-glass"></i>
                                            Pesquisar</button>
                                        <button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i>
                                            Criar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mainInfos" class="collapse animated show" aria-labelledby="collapseFilter"
                        data-parent="#accordion">
                        <div class="card-body">
                            <ul class="nav-tabs nav">
                                <li class="nav-item">
                                    <a href="#ownData" data-toggle="tab" class="active nav-link"><i
                                            class="fa-solid fa-user"></i> Dados pessoais</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#zipData" data-toggle="tab" class="nav-link"><i
                                            class="fa-solid fa-house"></i> Dados postais</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#contactData" data-toggle="tab" class=" nav-link"><i
                                            class="fa-solid fa-phone"></i> Contatos</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="ownData" class="tab-pane active container">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="label">Nome:</label>
                                            <input type="text" id="nameSelect" class="form-control">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="label">CPF:</label>
                                            <input type="text" id="itrSelect" class="form-control">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="label">Data de aniversário:</label>
                                            <input type="text" id="birthdateSelect" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div id="zipData" class="tab-pane container">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="label">Estado:</label>
                                            <select name="" id="stateSelect" class="form-control">
                                                <option value="">Nada selecionado</option>
                                                <?php
                                                foreach ($allState['response'] as $data):
                                                    echo "<option value='" . $data['id'] . "'>" . $data['nameState'] . " - " . $data['uf'] . "</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="label">Cidade:</label>
                                            <input type="text" id="citySelect" class="form-control">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="label">Bairro:</label>
                                            <input type="text" id="neighborhoodSelect" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div id="contactData" class="tab-pane container">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="label">Telefone:</label>
                                            <input type="text" id="phoneSelect" class="form-control">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="label">E-mail:</label>
                                            <input type="text" id="emailSelect" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mt-4 animated fade-in-down" style="overflow-x: auto" id="tableDiv">
        </div>
    </div>

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav-tabs nav">
                        <li class="nav-item">
                            <a href="#ownDataUpdate" data-toggle="tab" class="active nav-link"><i
                                    class="fa-solid fa-user"></i> Dados pessoais</a>
                        </li>
                        <li class="nav-item">
                            <a href="#zipDataUpdate" data-toggle="tab" class="nav-link"><i
                                    class="fa-solid fa-house"></i>
                                Dados postais</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contactDataUpdate" data-toggle="tab" class=" nav-link"><i
                                    class="fa-solid fa-phone"></i>
                                Contatos</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="ownDataUpdate" class="tab-pane active container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Nome:</label>
                                    <input type="text" id="nameUpdate" class="form-control">
                                    <input type="hidden" disabled id="idUserUpdate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">CPF:</label>
                                    <input type="text" id="itrUpdate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Data de aniversário:</label>
                                    <input type="text" id="birthdateUpdate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="zipDataUpdate" class="tab-pane container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Estado:</label>
                                    <select name="" id="stateUpdate" class="form-control">
                                        <option value="">Nada selecionado</option>
                                        <?php
                                        foreach ($allState['response'] as $data):
                                            echo "<option value='" . $data['id'] . "'>" . $data['nameState'] . " - " . $data['uf'] . "</option>";
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Cidade:</label>
                                    <input type="text" id="cityUpdate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Bairro:</label>
                                    <input type="text" id="neighborhoodUpdate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="contactDataUpdate" class="tab-pane container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Telefone:</label>
                                    <input type="text" id="phoneUpdate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">E-mail:</label>
                                    <input type="text" id="emailUpdate" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="Update" class="btn btn-primary">Salvar alterações</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="CreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CreateModalLabel">Criar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav-tabs nav">
                        <li class="nav-item">
                            <a href="#ownDataCreate" data-toggle="tab" class="active nav-link"><i
                                    class="fa-solid fa-user"></i> Dados pessoais</a>
                        </li>
                        <li class="nav-item">
                            <a href="#zipDataCreate" data-toggle="tab" class="nav-link"><i
                                    class="fa-solid fa-house"></i>
                                Dados postais</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contactDataCreate" data-toggle="tab" class=" nav-link"><i
                                    class="fa-solid fa-phone"></i>
                                Contatos</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="ownDataCreate" class="tab-pane active container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Nome:</label>
                                    <input type="text" id="nameCreate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">CPF:</label>
                                    <input type="text" id="itrCreate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Data de aniversário:</label>
                                    <select name="birthdateCreate" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div id="zipDataCreate" class="tab-pane container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Estado:</label>
                                    <select name="" id="stateCreate" class="form-control">
                                        <option value="">Nada selecionado</option>
                                        <?php
                                        foreach ($allState['response'] as $data):
                                            echo "<option value='" . $data['id'] . "'>" . $data['nameState'] . " - " . $data['uf'] . "</option>";
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Cidade:</label>
                                    <input type="text" id="cityCreate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">Bairro:</label>
                                    <input type="text" id="neighborhoodCreate" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="contactDataCreate" class="tab-pane container">
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="label">Telefone:</label>
                                    <input type="text" id="phoneCreate" class="form-control">
                                </div>

                                <div class="col-lg-4">
                                    <label class="label">E-mail:</label>
                                    <input type="text" id="emailCreate" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar alterações</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="/view/home/app.js"></script>
</body>

</html>