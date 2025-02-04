<?php session_start();
$login = "";
if (isset($_SESSION['login'])) {
  $login = $_SESSION['login'];
  unset($_SESSION['login']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

  <title>Painel de Administração</title>
</head>

<?php include_once "header.php"; ?>

<style>
  <?php include_once "css/main.css" ?>
</style>

<body class="white">
  <div class="container center-align">
    <h1>Bem-vindo ao Painel de Administração do IFFar</h1>
    <div class="row">

      <!--ENTRADA-->
      <?php if ($_SESSION['Perfil'] == 1) { ?>
        <div class="col s12 m6 l4">
          <div class="card blue darken-2 custom-card">
            <div class="card-content white-text">
              <i class="fas fa-sign-in-alt"></i>

              <h5>Entrada em atraso</h5>
            </div>

            <a href="#modal-entrada" class="white-text modal-trigger">
              <div class="card-action">
                ACESSAR
              </div>
            </a>
          </div>
        </div>
      <?php } ?>

      <div id="modal-entrada" class="modal">
        <div class="modal-content">
          <h4 class="center-align">Registrar Entrada Em Atraso</h4>
          <form id="form-entrada">
            <!-- Campo Nome -->
            <div class="input-field">
              <i class="material-icons prefix"></i> <!-- Ícone opcional -->
              <input type="text" id="registroAtrasoNome" name="nome" placeholder disabled class="validate" required>
             
            </div>

            <input type="hidden" id="registroAtrasoCPF" name="cpf" required>

            <!-- Campo Data -->
            <div class="input-field">
              <i class="material-icons prefix"></i>
              <input type="date" id="registroAtrasoData" name="data" required>
              <label for="data">Data</label>
            </div>

            <!-- Campo Horário -->
            <div class="input-field">
              <i class="material-icons prefix"></i>
              <input type="time" id="registroAtrasoHorario" name="horario" required>
              <label for="horario">Horário</label>
            </div>

            <!-- Campo Turma -->
            <div class="input-field">
              <i class="material-icons prefix"></i>
              <textarea id="registroAtrasoTurma" name="turma" class="materialize-textarea" disabled required></textarea>
           
            </div>

            <!-- Campo Motivo -->
            <div class="input-field">
              <i class="material-icons prefix"></i>
              <textarea id="motivo" name="motivo" class="materialize-textarea" required></textarea>
              <label for="motivo">Motivo do atraso</label>
            </div>

            <!-- Campo Matricula -->
            <div class="input-field">
              <i class="material-icons prefix"></i> <!-- Ícone opcional -->
              <input id="registroAtrasoMatricula" name="matricula" type="text" class="validate" required>
              <label for="registroAtrasoMatricula">Matrícula</label>
              <input type="button" onclick="pesquisarMatricula()"> Pesquisar</input>
            </div>





            <!-- Botão Registrar -->
            <div class="center-align">
              <button type="submit" class="btn waves-effect waves-light">
                <i class="material-icons left"></i>Registrar
              </button>
            </div>
          </form>
        </div>

        <!-- Rodapé do Modal -->
        <div class="modal-footer">
          <a href="#!" class="modal-close btn red lighten-1 waves-effect waves-light">
            <i class="material-icons left"></i>Fechar
          </a>
        </div>
      </div>


      <script>
        document.addEventListener('DOMContentLoaded', () => {
          // Inicializa os modais
          M.Modal.init(document.querySelectorAll('.modal'));

          // Envio do formulário via AJAX
          const formEntrada = document.getElementById('form-entrada');
          formEntrada?.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
              const formData = new FormData(formEntrada);
              const response = await fetch('botoesmain/salvar_entrada2.php', {
                method: 'POST',
                body: formData
              });
              const data = await response.text();
              Swal.fire('Sucesso!', data, 'success');
              M.Modal.getInstance(document.querySelector('#modal-entrada')).close();
              formEntrada.reset();
            } catch {
              Swal.fire('Erro!', 'Houve um problema ao salvar a entrada.', 'error');
            }
          });

          // Exibe alerta de login, se necessário
          <?php if ($login != "") { ?>
            Swal.fire(<?= json_encode($login) ?>);
          <?php } ?>
        });
      </script>

</html>
<!-- FIM da ENTRADA -->







<!-- SAÍDA -->
<div class="col s12 m6 l4">
  <div class="card pink darken-2 custom-card">
    <div class="card-content white-text">
      <i class="fas fa-sign-out-alt"></i>
      <h5>Saída fora de horário</h5>
    </div>

    <a href="#modal-saida" class="white-text modal-trigger">
      <div class="card-action">
        ACESSAR
      </div>
    </a>
  </div>
</div>

<!-- Modal de Saída -->
<div id="modal-saida" class="modal">
  <div class="modal-content">
    <h4 class="center-align">Registrar Saída Fora de Horário</h4>
    <form id="form-saida">
      <!-- Campo Nome -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <input type="text" id="nome" name="nome" required>
        <label for="nome">Nome completo</label>
      </div>

      <!-- Campo Data -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <input type="date" id="data" name="data" required>
        <label for="data">Data</label>
      </div>

      <!-- Campo Horário -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <input type="time" id="horario" name="horario" required>
        <label for="horario">Horário</label>
      </div>

      <!-- Campo turma -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <textarea id="turma" name="turma" class="materialize-textarea" required></textarea>
        <label for="turma">Turma</label>
      </div>

      <!-- Campo Motivo -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <textarea id="motivo" name="motivo" class="materialize-textarea" required></textarea>
        <label for="motivo">Motivo da saída fora de horário</label>
      </div>

      <!-- Campo matricula -->
      <div class="input-field">
        <i class="material-icons prefix"></i>
        <textarea id="matricula" name="matricula" class="materialize-textarea" required></textarea>
        <label for="matricula">matricula</label>
      </div>

      <input type="hidden" name="tipo" value="saida">

      <!-- Botão Registrar -->
      <div class="center-align">
        <button type="submit" class="btn waves-effect waves-light">
          <i class="material-icons left"></i>Registrar
        </button>
      </div>
    </form>
  </div>

  <!-- Rodapé do Modal -->
  <div class="modal-footer">
    <a href="#!" class="modal-close btn red lighten-1 waves-effect waves-light">
      <i class="material-icons left"></i>Fechar
    </a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Inicializa os modais
    M.Modal.init(document.querySelectorAll('.modal'));

    // Envio do formulário via AJAX
    const formSaida = document.getElementById('form-saida');
    formSaida?.addEventListener('submit', async (e) => {
      e.preventDefault();
      try {
        const formData = new FormData(formSaida);
        const response = await fetch('botoesmain/salvar_saida.php', {
          method: 'POST',
          body: formData
        });
        const data = await response.text();
        Swal.fire('Sucesso!', data, 'success');
        M.Modal.getInstance(document.querySelector('#modal-saida')).close();
        formSaida.reset();
      } catch {
        Swal.fire('Erro!', 'Houve um problema ao salvar a saída.', 'error');
      }
    });


  });
</script>

<!-- FIM da SAÍDA -->


<!--relatorio-->



<div class="col s12 m6 l4">
  <div class="card orange darken-2 custom-card">
    <div class="card-content white-text">
      <i class="fas fa-file-alt"></i>
      <h5>Relatorio Diario</h5>
    </div>

    <a href="#modal_relatorio_diario" class="white-text modal-trigger">
      <div class="card-action">
        ACESSAR
      </div>
    </a>

  </div>
</div>





<!-- Modal de Relatório Diário com Filtros -->
<div id="modal_relatorio_diario" class="modal">
  <div class="modal-content">
    <h4 class="center-align">Relatório Diário</h4>

    <!-- Filtros -->
    <div class="row">
      <div class="input-field col s12 m6 l3">
        <select id="filtro-nome">
          <option value="" disabled selected>Filtrar por Nome</option>
          <!-- Opções serão carregadas dinamicamente -->
        </select>
      </div>
      <div class="input-field col s12 m6 l3">
        <select id="filtro-matricula">
          <option value="" disabled selected>Filtrar por Matrícula</option>
          <!-- Opções serão carregadas dinamicamente -->
        </select>
      </div>
      <div class="input-field col s12 m6 l3">
        <select id="filtro-turma">
          <option value="" disabled selected>Filtrar por Turma</option>
          <!-- Opções serão carregadas dinamicamente -->
        </select>
      </div>
      <div class="input-field col s12 m6 l3">
        <input type="date" id="filtro-data-inicial" placeholder="Data Inicial">
      </div>
      <div class="input-field col s12 m6 l3">
        <input type="date" id="filtro-data-final" placeholder="Data Final">
      </div>
    </div>

    <!-- Botão de Aplicar Filtros -->
    <div class="center-align">
      <button id="aplicar-filtros" class="btn waves-effect waves-light">
        <i class="material-icons left">filter_list</i>Aplicar Filtros
      </button>
    </div>

    <!-- Tabela de Resultados -->
    <table class="highlight">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Matrícula</th>
          <th>Turma</th>
          <th>Tipo</th>
          <th>Data</th>
          <th>Horário</th>
          <th>Motivo</th>
        </tr>
      </thead>
      <tbody id="tabela-Relatorio_diario">
        <!-- Os dados serão carregados aqui via AJAX -->
      </tbody>
    </table>
  </div>

  <!-- Rodapé do Modal -->
  <div class="modal-footer">
    <a href="#!" class="modal-close btn red lighten-1 waves-effect waves-light">
      <i class="material-icons left"></i>Fechar
    </a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Inicializa selects do Materialize
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    // Função para carregar as opções dos filtros
    const carregarOpcoesFiltros = async () => {
      try {
        const response = await fetch('botoesmain/obter_opcoes_filtros.php');
        if (!response.ok) throw new Error('Erro ao obter opções de filtros');
        const {
          nomes,
          matriculas,
          turmas
        } = await response.json();

        const filtroNome = document.getElementById('filtro-nome');
        nomes.forEach(nome => {
          filtroNome.innerHTML += `<option value="${nome}">${nome}</option>`;
        });

        const filtroMatricula = document.getElementById('filtro-matricula');
        matriculas.forEach(matricula => {
          filtroMatricula.innerHTML += `<option value="${matricula}">${matricula}</option>`;
        });

        const filtroTurma = document.getElementById('filtro-turma');
        turmas.forEach(turma => {
          filtroTurma.innerHTML += `<option value="${turma}">${turma}</option>`;
        });

        // Re-inicializa os selects do Materialize
        M.FormSelect.init(selects);
      } catch (error) {
        console.error('Erro ao carregar opções de filtros:', error);
      }
    };

    // Função para carregar o relatório diário com filtros
    const carregarRelatorioDiario = async (filtros = {}) => {
      try {
        const query = new URLSearchParams(filtros).toString();
        const response = await fetch(`botoesmain/relatorio_diario.php?${query}`);
        if (!response.ok) throw new Error('Erro na resposta do servidor');

        const registros = await response.json();
        const tabela = document.getElementById('tabela-Relatorio_diario');
        tabela.innerHTML = ''; // Limpa a tabela

        if (registros.length > 0) {
          registros.forEach(registro => {
            tabela.innerHTML += `
              <tr>
                <td>${registro.nome}</td>
                <td>${registro.matricula}</td>
                <td>${registro.turma}</td>
                <td>${registro.tipo}</td>
                <td>${registro.data}</td>
                <td>${registro.horario}</td>
                <td>${registro.motivo || '-'}</td>
              </tr>
            `;
          });
        } else {
          tabela.innerHTML = `
            <tr>
              <td colspan="7" class="center-align">Nenhum registro encontrado</td>
            </tr>
          `;
        }
      } catch (error) {
        console.error('Erro ao carregar o relatório diário:', error);
      }
    };

    // Evento para aplicar filtros ao clicar no botão
    document.getElementById('aplicar-filtros').addEventListener('click', () => {
      const filtros = {
        nome: document.getElementById('filtro-nome').value,
        matricula: document.getElementById('filtro-matricula').value,
        turma: document.getElementById('filtro-turma').value,
        data_inicial: document.getElementById('filtro-data-inicial').value,
        data_final: document.getElementById('filtro-data-final').value,
      };
      carregarRelatorioDiario(filtros);
    });

    // Carrega as opções dos filtros ao abrir o modal
    M.Modal.init(document.querySelectorAll('.modal'), {
      onOpenStart: () => {
        carregarOpcoesFiltros();
        carregarRelatorioDiario();
      },
    });
  });
</script>

<div class="col s12 m6 l4">
  <div class="card grey darken-2 custom-card">
    <div class="card-content white-text">
      <i class="fas fa-calendar-alt"></i>
      <h5>Agendamentos</h5>
    </div>
    <div class="card-action">
      <a href="#" class="white-text">Acessar</a>
    </div>
  </div>
</div>

<div class="col s12 m6 l4">
  <div class="card green darken-2 custom-card">
    <div class="card-content white-text">
      <i class="fas fa-user-graduate"></i>
      <h5>Alunos</h5>
    </div>

    <a href="alunos.php" class="white-text">
      <div class="card-action">
        ACESSAR

      </div>
    </a>
  </div>
</div>









<div class="col s12 m6 l4">
  <div class="card cyan darken-2 custom-card">
    <div class="card-content white-text">
      <i class="fas fa-file-alt"></i>
      <h5>Relatorio</h5>
    </div>
    <a href="#modal-Relatorio" class="white-text modal-trigger">
      <div class="card-action">
        ACESSAR
      </div>
    </a>
  </div>
</div>
</div>
</div>

<!-- Modal de Relatório -->
<div id="modal-Relatorio" class="modal">
  <div class="modal-content">
    <h4 class="center-align">Relatorio </h4>

    <!-- Barra de Pesquisa -->
    <div class="input-field">
      <i class="material-icons prefix"></i>
      <input type="text" id="busca-Relatorio" placeholder="Digite para buscar (nome, matrícula, turma)">
    </div>

    <!-- Tabela de Resultados -->
    <table class="highlight">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Matrícula</th>
          <th>Turma</th>
          <th>Tipo</th>
          <th>Data</th>
          <th>Horário</th>
          <th>Motivo</th>
        </tr>
      </thead>
      <tbody id="tabela-Relatorio">
        <!-- Os dados serão carregados aqui via AJAX -->
      </tbody>
    </table>
  </div>

  <!-- Rodapé do Modal -->
  <div class="modal-footer">
    <a href="#!" class="modal-close btn red lighten-1 waves-effect waves-light">
      <i class="material-icons left"></i>Fechar
    </a>
  </div>
</div>

<?php include_once "footer.php" ?>

<script>
  <?php if ($login != "") { ?>
    window.addEventListener("load", (event) => {
      Swal.fire(
        <?= json_encode($login) ?>
      )
    })
  <?php } ?>

  document.addEventListener('DOMContentLoaded', () => {
    // Inicializa os modais
    const modals = M.Modal.init(document.querySelectorAll('.modal'), {
      onOpenStart: (modalElement) => {
        if (modalElement.id === 'modal_relatorio_diario') {
          carregarRelatorio_diario(); // Carrega os dados do Relatório Diário quando o modal é aberto
        } else if (modalElement.id === 'modal-Relatorio') {
          carregarRelatorio(); // Carrega os dados do Relatório quando o modal é aberto
        }
      }
    });

    // Função para carregar os dados do Relatório Diário
    const carregarRelatorio_diario = async (busca = '') => {
      try {
        const response = await fetch(`botoesmain/relatorio_diario.php?busca=${encodeURIComponent(busca)}`);
        if (!response.ok) {
          throw new Error('Erro na resposta do servidor');
        }
        const registros = await response.json();

        const tabela = document.getElementById('tabela-Relatorio_diario');
        tabela.innerHTML = ''; // Limpa a tabela

        // Popula a tabela com os registros
        if (registros.length > 0) {
          registros.forEach((registro) => {
            tabela.innerHTML += `
            <tr>
              <td>${registro.nome}</td>
              <td>${registro.matricula}</td>
              <td>${registro.turma}</td>
              <td>${registro.tipo}</td>
              <td>${registro.data}</td>
              <td>${registro.horario}</td>
              <td>${registro.motivo || '-'}</td>
            </tr>
          `;
          });
        } else {
          tabela.innerHTML = `
          <tr>
            <td colspan="7" class="center-align">Nenhum registro encontrado</td>
          </tr>
        `;
        }
      } catch (error) {
        console.error('Erro ao carregar o relatório diário:', error);
      }
    };

    // Função para carregar os dados do Relatório
    const carregarRelatorio = async (busca = '') => {
      try {
        const response = await fetch(`botoesmain/relatorio.php?busca=${encodeURIComponent(busca)}`);
        if (!response.ok) {
          throw new Error('Erro na resposta do servidor');
        }
        const registros = await response.json();

        const tabela = document.getElementById('tabela-Relatorio');
        tabela.innerHTML = ''; // Limpa a tabela

        // Popula a tabela com os registros
        if (registros.length > 0) {
          registros.forEach((registro) => {
            tabela.innerHTML += `
            <tr>
              <td>${registro.nome}</td>
              <td>${registro.matricula}</td>
              <td>${registro.turma}</td>
              <td>${registro.tipo}</td>
              <td>${registro.data}</td>
              <td>${registro.horario}</td>
              <td>${registro.motivo || '-'}</td>
            </tr>
          `;
          });
        } else {
          tabela.innerHTML = `
          <tr>
            <td colspan="7" class="center-align">Nenhum registro encontrado</td>
          </tr>
        `;
        }
      } catch (error) {
        console.error('Erro ao carregar o relatório:', error);
      }
    };

    // Evento para buscar enquanto digita no campo de pesquisa
    const buscaInputDiario = document.getElementById('busca-Relatorio_diario');
    buscaInputDiario.addEventListener('input', () => {
      carregarRelatorio_diario(buscaInputDiario.value);
    });




    const buscaInputRelatorio = document.getElementById('busca-Relatorio');
    buscaInputRelatorio.addEventListener('input', () => {
      carregarRelatorio(buscaInputRelatorio.value);
    });
  });


  async function pesquisarMatricula() {
    try {
      const matricula = document.getElementById("registroAtrasoMatricula").value;

      const response = await fetch(`botoesmain/pesq_matricula.php?matricula=${matricula}`);
      if (!response.ok) {
        throw new Error('Erro na resposta do servidor');
      }

      const data = await response.json(); // Caso a resposta seja JSON

      const nomeInput = document.getElementById("registroAtrasoNome");
      const cpfInput = document.getElementById("registroAtrasoCPF");
      const turmaInput = document.getElementById("registroAtrasoTurma");

     

      nomeInput.value = data.nome;
      cpfInput.value = data.cpf;
      turmaInput.value = data.turma;





      console.log(data);
    } catch (error) {
      console.error('Erro ao pesquisar matrícula:', error.message);

    }
  }
</script>