@extends('theme/theme');

@section('title', 'Serviços')

@section('content') 
<div class="ml-5 mr-5 mt-5">
    <h2>Serviços</h2>
    <div class="botoes">
        <button id="novoServico" class="btn bg-gradient-purple">Novo</button>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="novoModal" style="display: none;">
        <form id="formNovoServico" class="card-body">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="profissao">Valor</label>
                <input type="number"  class="form-control" id="valor" name="valor" required>
            </div>
            <button type="submit" class="btn bg-gradient-purple">Salvar</button>
        </form>
    </div>
    <div id="editarModal" style="display: none;">
        <form id="formEditarServico" class="card-body">
            @csrf
            <br />
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="profissao">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" required>
            </div>
            <button type="submit" class="btn bg-gradient-purple">Salvar</button>
        </form>
    </div>
    <div id="deleteModal" style="display: none;">
        <form class="form-group container">
            <div class="card-body">
                @csrf
                <p>Você tem certeza que deseja excluir este serviço?</p>
                <p id="deleteMessage"></p>
            
                <button id="confirmDelete" class="btn bg-gradient-purple">Excluir</button>
                <button id="cancelDelete" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
    <br />

    <!-- Table servicos -->
    <table id="servicos-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('js')
<!-- Importando arquivo JS adicional -->
<script>
$(document).ready(function() {
    // Inicializar iziModal
  $('#novoModal').iziModal({
      title: 'Novo serviço',
      subtitle: 'Preencha os campos para adicionar um novo serviço.',
      headerColor: '#6f42c1', // Cor do cabeçalho
      width: 600, // Largura do modal
      overlayClose: false, // Não fecha ao clicar fora
  });

  // Inicializar iziModal
  $('#editarModal').iziModal({
      title: 'Editar serviço',
      subtitle: 'Altere os campos desejados.',
      headerColor: '#6f42c1',
      width: 600,
      overlayClose: false,
  });

  // Abrir modal para edição
  $(document).on('click', '.edit-btn', function() {
      const id = $(this).data('id');

      // Fazer requisição AJAX para buscar os dados
      $.ajax({
          url: `/servicos/${id}/edit`, // Rota para buscar os dados
          method: 'GET',
          success: function(data) {
              // Preencher os campos do formulário com os dados retornados
              $('#formEditarServico #nome').val(data.nome);
              $('#formEditarServico #valor').val(parseFloat(data.valor).toFixed(2));

              // Alterar o evento submit para enviar o update
              $('#formEditarServico').off('submit').on('submit', function(event) {
                  event.preventDefault(); // Evitar reload

                  const formData = $(this).serialize(); // Serializa os dados

                  // Enviar requisição AJAX para update
                  $.ajax({
                      url: `/servicos/${id}`, // Rota para update
                      method: 'PUT',
                      data: formData,
                      success: function(response) {
                            $('#editarModal').iziModal('close');
                            $('#formEditarServico')[0].reset();
                            $('#servicos-table').DataTable().ajax.reload();

                            iziToast.success({
                                message: `Seviço editado com sucesso!`,
                            });
                      },
                      error: function(xhr) {
                        iziToast.error({
                            message: `Erro ao editar serviço.`,
                        });
                      }
                  });
              });

              // Abrir o modal
              $('#editarModal').iziModal('open');
          },
          error: function(xhr) {
              alert('Erro ao carregar os dados do profissional.');
              console.error(xhr.responseText);
          }
      });
  });

  // Abrir modal ao clicar no botão "Novo"
  $('#novoServico').on('click', function() {
      $('#novoModal').iziModal('open');
  });


  $('#formNovoServico').on('submit', function(event) {
      event.preventDefault(); // Evita o reload da página

      const formData = $(this).serialize(); // Serializa os dados do formulário

      $.ajax({
          url: "{{route('servicos.store') }}",
          method: 'POST',
          data: formData,
          success: function(response) {
                // Fechar o modal e resetar o formulário
                $('#novoModal').iziModal('close');
                $('#formNovoServico')[0].reset();

                // Atualizar a tabela
                $('#servicos-table').DataTable().ajax.reload();

                iziToast.success({
                    message: `Seviço cadastrado com sucesso!`,
                });
          },
          error: function(xhr) {
            iziToast.error({
                message: `Erro ao cadastrar serviço!`,
            });
          }
      });
  });

  $('#deleteModal').iziModal({
      title: 'Confirmar Exclusão',
      subtitle: 'Tem certeza de que deseja excluir?',
      headerColor: '#6f42c1',
      width: 400,
      overlayClose: false,
      closeButton: true,
  });

  // Quando o botão de excluir for clicado
  $(document).on('click', '.delete-btn', function() {
      const id = $(this).data('id'); // Obter o ID do profissional

      // Exibir o modal de confirmação
      $('#deleteModal').iziModal('open');

      // Quando o botão de confirmar exclusão for clicado
      $('#confirmDelete').off('click').on('click', function() {
          // Fazer a requisição AJAX para excluir o profissional
          $.ajax({
              url: `/servicos/${id}`, // Rota para excluir o profissional
              method: 'DELETE',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                    // Fechar o modal
                    $('#deleteModal').iziModal('close');

                    // Atualizar a tabela
                    $('#servicos-table').DataTable().ajax.reload();

                    iziToast.success({
                        message: `Seviço deletado com sucesso!`,
                    });
              },
              error: function(xhr) {
                iziToast.error({
                    message: `Erro ao deletar serviço.`,
                });
              }
          });
      });

      // Quando o botão de cancelar for clicado
      $('#cancelDelete').off('click').on('click', function() {
          // Fechar o modal
          $('#deleteModal').iziModal('close');
      });
  });


  $('#servicos-table').DataTable({
      
      processing: true,
      serverSide: true,
      ajax: "{{ route('servicos.index') }}",
      language: {
          decimal: ",",
          thousands: ".",
          search: "Pesquisar:",
          lengthMenu: "Mostrar _MENU_ registros",
          info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
          infoEmpty: "Mostrando 0 registros",
          infoFiltered: "(filtrado de _MAX_ registros no total)",
          loadingRecords: "Carregando...",
          zeroRecords: "Nenhum registro encontrado",
          emptyTable: "Nenhum dado disponível na tabela",
          paginate: {
              first: "Primeiro",
              previous: "Anterior",
              next: "Próximo",
              last: "Último"
          },
          aria: {
              sortAscending: ": ativar para ordenar a coluna em ordem crescente",
              sortDescending: ": ativar para ordenar a coluna em ordem decrescente"
          }
      },
      columns: [
          { data: 'nome', name: 'nome' },
          { 
                data: 'valor', 
                name: 'valor',
                render: function (data, type, row) {
                    return `R$ ${parseFloat(data).toFixed(2)}`; // Formata como float com 2 casas decimais
                }
            },
          { 
              data: null, // Não vem do servidor, é gerado localmente
              name: 'actions',
              orderable: false,
              searchable: false,
              render: function(data, type, row) {
                  return `
                      <div class="text-center">
                          <button class="btn btn-sm bg-gradient-purple edit-btn" data-id="${row.id}">
                              <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm bg-gradient-secondary delete-btn" data-id="${row.id}">
                              <i class="fas fa-trash"></i>
                          </button>
                      </div>
                  `;
              },
          }
      ]
  });
});
</script>
@endsection