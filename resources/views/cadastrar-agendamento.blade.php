@extends('theme/theme');

@section('title', 'Cadadastrar agendamento')

@section('content') 
<div class="ml-5 mr-5 mt-5">

    <h2>Cadastrar agenda</h2>
    <!-- Seleção de Profissional -->
    <div class="d-flex">
        <label for="profissional" class="mt-1 mr-2">Selecione um Profissional: </label>
        <select id="profissional" name="profissional" class="form-control  w-25">
            @foreach ($profissionais as $profissional)
                <option value="{{$profissional->id}}">{{$profissional->id}} {{$profissional->nome}}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabela de Dias e Horários -->
    <table id="tabela-horarios" class="display table table-striped table-bordered">
        <thead>
            <tr>
                <th>Dia da Semana</th>
                <th>Horários</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diasDaSemana as $dia)
                <tr>
                    <td class="diaDaSemana" id="{{$dia->id}}">{{ $dia->nome }}</td>
                    <td class="horarios"></td>
                    <td>
                        <div class="text-center">
                            <button class="btn bg-gradient-purple" id="btnHorario" id-dia="{{ $dia->id }}">Adicionar Horário</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button id="salvar-agendamento" class="btn bg-gradient-purple mt-2">Salvar agenda</button>
</div>
 <!-- Modal para Adicionar Horário -->
 <div id="modalAdicionarHorario" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarHorarioLabel" aria-hidden="true">
        <div class="modal-content">
            <form id="novoHorario" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="profissional_id" name="profissional_id">
                    <div class="form-group">
                        <label for="hora_inicio">Horário de Início</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_fim">Horário de Fim</label>
                        <input type="time" class="form-control" id="hora_fim" name="hora_fim" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="fecharModal" class="btn bg-gradient-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn bg-gradient-purple">Salvar</button>
                </div>
            </form>
        </div>
</div>
@endsection
@section('js')
<!-- Importando arquivo JS adicional -->
<script>
    $(document).ready(function () {
        // Inicializa o DataTable
        const tabelaHorarios = $('#tabela-horarios').DataTable({
            paging: false,
            searching: false,
            info: false,
        });

        // Carregar os profissionais no select
        $.get('/profissionais', function (data) {
            data.forEach(profissional => {
                $('#profissional').append(`<option value="${profissional.id}">${profissional.nome}</option>`);
            });
        });

        // Adicionar horário para o dia da semana
        $('#modalAdicionarHorario').iziModal({
            title: 'Novo horário',
            subtitle: 'Preencha os campos para adicionar um novo horário.',
            headerColor: '#6f42c1', // Cor do cabeçalho
            width: 600, // Largura do modal
            overlayClose: false, // Não fecha ao clicar fora
        });

        $('#btnHorario').on('click', function() {
            $('#modalAdicionarHorario').iziModal('open');
        });

        $('#fecharModal').on('click', function() {
            $('#modalAdicionarHorario').iziModal('close');
        });

        // Salvar agendamento
        $('#novoHorario').on('submit', function(event) {
            event.preventDefault(); // Evita o reload da página
            var valorSelecionado = $('#profissional').val();
            $('#profissional_id').val(valorSelecionado);
            const formData = $(this).serialize(); // Serializa os dados do formulário

            $.ajax({
                url: "{{route('agendas.store') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                        // Fechar o modal e resetar o formulário
                        $('#novoModal').iziModal('close');
                        $('#novoHorario')[0].reset();

                        // Atualizar a tabela
                        $('#tabela-horarios').DataTable().ajax.reload();
                        iziToast.success({
                            message: 'Horário cadastrado com sucesso!',
                        });
                },
                error: function(xhr) {
                    iziToast.error({
                        message: `Erro ao cadastrar horário: ${xhr.responseText}`,
                    });
                }
            });
    });
});
</script>
@endsection