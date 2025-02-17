$(document).ready(function() {
    // Inicializar iziModal
  $('#novoModal').iziModal({
      title: 'Novo Profissional',
      subtitle: 'Preencha os campos para adicionar um novo profissional.',
      headerColor: '#6f42c1', // Cor do cabeçalho
      width: 600, // Largura do modal
      overlayClose: false, // Não fecha ao clicar fora
  });

  // Inicializar iziModal
  $('#editarModal').iziModal({
      title: 'Editar Profissional',
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
          url: `/profissionais/${id}/edit`, // Rota para buscar os dados
          method: 'GET',
          success: function(data) {
              // Preencher os campos do formulário com os dados retornados
              $('#formEditarProfissional #nome').val(data.nome);
              $('#formEditarProfissional #profissao').val(data.profissao);

              // Alterar o evento submit para enviar o update
              $('#formEditarProfissional').off('submit').on('submit', function(event) {
                  event.preventDefault(); // Evitar reload

                  const formData = $(this).serialize(); // Serializa os dados

                  // Enviar requisição AJAX para update
                  $.ajax({
                      url: `/profissionais/${id}`, // Rota para update
                      method: 'PUT',
                      data: formData,
                      success: function(response) {
                          $('#editarModal').iziModal('close');
                          $('#formEditarProfissional')[0].reset();
                          $('#profissionais-table').DataTable().ajax.reload();

                          alert('Profissional atualizado com sucesso!');
                      },
                      error: function(xhr) {
                          alert('Erro ao atualizar o profissional.');
                          console.error(xhr.responseText);
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
  $('#novoProfissional').on('click', function() {
      $('#novoModal').iziModal('open');
  });


  $('#formNovoProfissional').on('submit', function(event) {
      event.preventDefault(); // Evita o reload da página

      const formData = $(this).serialize(); // Serializa os dados do formulário

      $.ajax({
          url: "{{route('profissionais.store') }}",
          method: 'POST',
          data: formData,
          success: function(response) {
              // Fechar o modal e resetar o formulário
              $('#novoModal').iziModal('close');
              $('#formNovoProfissional')[0].reset();

              // Atualizar a tabela
              $('#profissionais-table').DataTable().ajax.reload();

              alert('Profissional cadastrado com sucesso!');
          },
          error: function(xhr) {
              alert('Ocorreu um erro ao cadastrar o profissional.');
              console.error(xhr.responseText);
          }
      });
  });

  $('#deleteModal').iziModal({
      title: 'Confirmar Exclusão',
      subtitle: 'Tem certeza de que deseja excluir?',
      headerColor: '#e74a3b',
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
              url: `/profissionais/${id}`, // Rota para excluir o profissional
              method: 'DELETE',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  // Fechar o modal
                  $('#deleteModal').iziModal('close');

                  // Atualizar a tabela
                  $('#profissionais-table').DataTable().ajax.reload();

                  alert(response.message); // Mostrar mensagem de sucesso
              },
              error: function(xhr) {
                  alert('Erro ao excluir o profissional.');
                  console.error(xhr.responseText);
              }
          });
      });

      // Quando o botão de cancelar for clicado
      $('#cancelDelete').off('click').on('click', function() {
          // Fechar o modal
          $('#deleteModal').iziModal('close');
      });
  });


  $('#profissionais-table').DataTable({
      
      processing: true,
      serverSide: true,
      ajax: "{{ route('profissionais.index') }}",
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
          { data: 'profissao', name: 'profissao' },
          { 
              data: null, // Não vem do servidor, é gerado localmente
              name: 'actions',
              orderable: false,
              searchable: false,
              render: function(data, type, row) {
                  return `
                      <div class="text-center">
                          <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
                              <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                              <i class="fas fa-trash"></i>
                          </button>
                      </div>
                  `;
              },
          }
      ]
  });
});