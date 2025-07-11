<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\ImportacoesController;
use App\Http\Controllers\IndicadoresController;
use App\Http\Controllers\InstituicoesController;
use App\Http\Controllers\MissaoController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\OmsController;
use App\Http\Controllers\PlanodeferiasController;
use App\Http\Controllers\PostoGraduacoesController;
use App\Http\Controllers\SecoesController;
use App\Http\Controllers\SituacoesController;
use App\Http\Controllers\TipoMissaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AtividadesController;
use App\Http\Middleware\CheckAdminForRestrictedRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\ItinerarioController;

// rotas sem estar logado
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('login');
    });

    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->name('logar');
});

// rotas apenas logado
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Checagem de acesso para a rota restrita
    Route::middleware(CheckAdminForRestrictedRoute::class)
        ->get('/rota-restrita', function () {
            return view('rota-restrita');
        })->name('rota-restrita');

    Route::prefix('/administrativo')
        ->name('administrativo.')
        ->middleware(CheckAdminForRestrictedRoute::class)
        ->group(function () {
            Route::get('/militares', [UserController::class, 'militares'])->name('militares');
            Route::get('/militares/getall', [UserController::class, 'getAll'])->name('militares.getall');
            Route::post('/militar/show', [UserController::class, 'show'])->name('militar.show');
            Route::get('/militares/listar', [UserController::class, 'listarMilitares'])->name('militares.listar');
            Route::post('/militares/store', [UserController::class, 'store'])->name('militares.store');
            Route::post('/militares/delete', [UserController::class, 'destroy'])->name('militares.delete');
            Route::get('/militares/alterarsenha', [UserController::class, 'resetview'])->name('militares.alterarsenha');
            Route::post('/militares/alterarsenha', [AuthController::class, 'updatePassword'])->name('militares.updatePassword');
            Route::post('/militares/resetpassword', [UserController::class, 'resetarSenha'])->name('militares.resetpassword');

            Route::get('/instituicoes', [InstituicoesController::class, 'index'])->name('instituicoes.index');
            Route::get('/instituicoes/getall', [InstituicoesController::class, 'getAll'])->name('instituicoes.getall');
            Route::post('/instituicoes/store', [InstituicoesController::class, 'store'])->name('instituicoes.store');
            Route::post('/instituicoes/delete', [InstituicoesController::class, 'destroy'])->name('instituicoes.delete');

            Route::get('/secoes', [SecoesController::class, 'index'])->name('secoes.index');
            Route::get('/secoes/show', [SecoesController::class, 'show'])->name('secoes.show');
            Route::get('/secoes/getall', [SecoesController::class, 'getAll'])->name('secoes.getall');
            Route::post('/secoes/store', [SecoesController::class, 'store'])->name('secoes.store');
            Route::post('/secoes/delete', [SecoesController::class, 'destroy'])->name('secoes.delete');

            Route::get('/oms', [OmsController::class, 'index'])->name('oms.index');
            Route::get('/oms/getall', [OmsController::class, 'getAll'])->name('oms.getall');
            Route::get('/oms/show', [OmsController::class, 'show'])->name('oms.show');
            Route::post('/oms/store', [OmsController::class, 'store'])->name('oms.store');
            Route::post('/oms/delete', [OmsController::class, 'destroy'])->name('oms.delete');
            Route::get('/oms/{id}/secoes', [SecoesController::class, 'getSecoes']);

            Route::get('/situacoes', [SituacoesController::class, 'index'])->name('situacoes.index');
            Route::get('/situacoes/getall', [SituacoesController::class, 'getAll'])->name('situacoes.getall');
            Route::post('/situacoes/show', [SituacoesController::class, 'show'])->name('situacoes.show');
            Route::post('/situacoes/store', [SituacoesController::class, 'store'])->name('situacoes.store');
            Route::post('/situacoes/delete', [SituacoesController::class, 'destroy'])->name('situacoes.delete');

            Route::get('/pg', [PostoGraduacoesController::class, 'index'])->name('pg.index');
            Route::get('/pg/getall', [PostoGraduacoesController::class, 'getAll'])->name('pg.getall');
            Route::get('/pg/show', [PostoGraduacoesController::class, 'show'])->name('pg.show');
            Route::post('/pg/store', [PostoGraduacoesController::class, 'store'])->name('pg.store');
            Route::post('/pg/delete', [PostoGraduacoesController::class, 'destroy'])->name('pg.delete');

            Route::get('/modulos', [ModulosController::class, 'index'])->name('modulos.index');
            Route::get('/modulos/show', [ModulosController::class, 'show'])->name('modulos.show');
            Route::get('/modulos/getall', [ModulosController::class, 'getAll'])->name('modulos.getall');
            Route::post('/modulos/store', [ModulosController::class, 'store'])->name('modulos.store');
            Route::post('/modulos/delete', [ModulosController::class, 'destroy'])->name('modulos.delete');

            Route::get('/situacaomilitar', [SituacoesController::class, 'versituacoes'])->name('versituacoes');
            Route::get('/situacoesmilitares', [SituacoesController::class, 'situacoesmilitares'])->name('situacoesmilitares');
            Route::post('/salvarsituacoes', [SituacoesController::class, 'salvarsituacoes']);

            Route::get('/planodeferias', [PlanodeferiasController::class, 'index'])->name('planodeferias');
            Route::get('/getplanodeferias', [PlanodeferiasController::class, 'getplanodeferias'])->name('getplanodeferias');
            Route::post('/planodeferias/delete', [PlanodeferiasController::class, 'delete'])->name('planodeferias.delete');
            Route::post('/planodeferias/store', [PlanodeferiasController::class, 'store'])->name('planodeferias.store');
            Route::post('/planodeferias/show', [PlanodeferiasController::class, 'show'])->name('planodeferias.show');

            Route::get('/atividades', [AtividadesController::class, 'index'])->name('atividades.index');
            Route::get('/atividades/show', [AtividadesController::class, 'show'])->name('atividades.show');
            Route::post('/atividades/store', [AtividadesController::class, 'store'])->name('atividades.store');
            Route::post('/atividades/update', [AtividadesController::class, 'update'])->name('atividades.update');
            Route::post('/atividades/destroy', [AtividadesController::class, 'destroy'])->name('atividades.destroy');
            // Adicione esta rota para permitir o upload de missões via administrativo
            Route::post('/importacoes/missoes', [ImportacoesController::class, 'missoesupload'])->name('missoes.upload');
            Route::get('/militares/buscar', [UserController::class, 'buscar'])->name('militares.buscar');
            Route::post('/militares/get-veterano', [\App\Http\Controllers\UserController::class, 'getVeterano']);
        });

    Route::prefix('financeiro')->name('financeiro.')->group(function () {
        Route::get('/', [FinanceiroController::class, 'index'])->name('index');
        Route::get('/getall', [FinanceiroController::class, 'getAll'])->name('getall');
        Route::get('/show', [FinanceiroController::class, 'show'])->name('show');
        Route::post('/store', [FinanceiroController::class, 'store'])->name('store');
        Route::post('/delete', [FinanceiroController::class, 'destroy'])->name('delete');
        Route::get('/create', [FinanceiroController::class, 'create'])->name('novo');
    });

    Route::prefix('/e1')->group(function () {
        Route::get('/planodeferias', [PlanodeferiasController::class, 'index']);
        Route::post('/planodeferias/show', [PlanodeferiasController::class, 'show']);
        Route::post('/planodeferias/delete', [PlanodeferiasController::class, 'delete']);
        Route::get('/administrativo/getplanodeferias', [PlanodeferiasController::class, 'getplanodeferias']);
        Route::get('/descontoemferias', [\App\Http\Controllers\DescontoemferiasController::class, 'index']);
        Route::get('/descontoemferias/getall', [\App\Http\Controllers\DescontoemferiasController::class, 'getAll']);
        Route::post('/descontoemferias/store', [\App\Http\Controllers\DescontoemferiasController::class, 'store']);
        Route::post('/descontoemferias/show', [\App\Http\Controllers\DescontoemferiasController::class, 'show']);
        Route::post('/descontoemferias/delete', [\App\Http\Controllers\DescontoemferiasController::class, 'delete']);
        Route::get('/descontoemferias/download/{id}', [\App\Http\Controllers\DescontoemferiasController::class, 'download']);
        Route::post('/descontoemferias/get-descontos', [\App\Http\Controllers\DescontoemferiasController::class, 'getDescontos']);
    });

    Route::prefix('/operacional')->name('operacional.')->group(function () {
        // Rotas de Missões
        Route::prefix('missoes')->group(function () {
            Route::get('/', [MissaoController::class, 'index'])->name('missoes.index');
            Route::get('/criar', [MissaoController::class, 'create'])->name('missoes.create');
            Route::post('/', [MissaoController::class, 'store'])->name('missoes.store');
            Route::post('/{missao}/status', [MissaoController::class, 'atualizarStatus'])->name('missoes.status');
            Route::get('/{missao}/editar', [MissaoController::class, 'edit'])->name('missoes.edit');
            Route::put('/{missao}', [MissaoController::class, 'update'])->name('missoes.update');
            Route::delete('/{missao}', [MissaoController::class, 'destroy'])->name('missoes.destroy');
        });

        // Rotas de Municípios
        Route::get('/municipios', [MunicipioController::class, 'index'])->name('municipios');
        Route::post('/municipios/importar', [MunicipioController::class, 'importar'])->name('municipios.importar');
        Route::get('/municipios/getall', [MunicipioController::class, 'getall'])->name('municipios.getall');

        // Rotas de Tipo de Missão
        Route::get('/tipomissao', [TipoMissaoController::class, 'index'])->name('tipomissao');
        Route::get('/tipomissao/show', [TipoMissaoController::class, 'show'])->name('tipomissaoall');
        Route::get('/tipomissoes/getall', [TipoMissaoController::class, 'getAll'])->name('tipomissoes.getall');
        Route::post('/tipomissoes/store', [TipoMissaoController::class, 'store'])->name('tipomissoes.store');
        Route::post('/tipomissao/delete', [TipoMissaoController::class, 'destroy'])->name('tipomissoes.delete');

        // Rotas de Itinerários (corrigidas e organizadas)
        Route::prefix('itinerarios')->group(function () {
            Route::get('/', [ItinerarioController::class, 'index'])->name('itinerarios.index');
            Route::post('/', [ItinerarioController::class, 'store'])->name('itinerarios.store');
            Route::put('/{itinerario}', [ItinerarioController::class, 'update'])->name('itinerarios.update');
            Route::delete('/{itinerario}', [ItinerarioController::class, 'destroy'])->name('itinerarios.destroy');
            Route::get('/buscar-municipios', [ItinerarioController::class, 'buscarMunicipios'])
                ->name('itinerarios.buscar-municipios');
        });
    });

    Route::prefix('/importacoes')->name('importacoes.')->group(function () {
        Route::get('/ouvidoria', [ImportacoesController::class, 'ouvidoria'])->name('ouvidoria');
        Route::get('/custo', [ImportacoesController::class, 'custo'])->name('custo');
        Route::post('/custo', [ImportacoesController::class, 'custoupload'])->name('custo.upload');
        Route::get('/missoes', [ImportacoesController::class, 'missoes'])->name('missoes.importar');
        Route::post('/missoes', [ImportacoesController::class, 'missoesupload'])->name('missoes.upload');
        Route::get('/planilhao', [ImportacoesController::class, 'planilhao'])->name('planilhao');
        Route::post('/planilhao', [ImportacoesController::class, 'planilhaoupload'])->name('planilhao.upload');
    });

    Route::get('/perfil', [UserController::class, 'perfil'])->name('profile');

    Route::post('/sincronizar', function (Request $request) {
        Artisan::call('import:sheet');
        return back()->with('success', 'Sincronização concluída!');
    })->name('sincronizar');
});

Route::middleware('api')->group(function () {
    Route::prefix('/indicadores')->group(function () {
        Route::get('/totalmilitar', [IndicadoresController::class, 'totalmilitares']);
    });
});

Route::prefix('/gestao')->name('gestao.')->group(function () {
    Route::get('/atividades', [AtividadesController::class, 'index'])->name('atividades.index');
    Route::get('/atividades/show', [AtividadesController::class, 'show'])->name('atividades.show');
    Route::post('/atividades/store', [AtividadesController::class, 'store'])->name('atividades.store');
    Route::post('/atividades/update', [AtividadesController::class, 'update'])->name('atividades.update');
    Route::post('/atividades/destroy', [AtividadesController::class, 'destroy'])->name('atividades.destroy');
});

Route::middleware(['auth'])->group(function() {
    Route::resource('objetivos', ObjetivoController::class)->only(['index', 'store', 'destroy', 'update']);
});