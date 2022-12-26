<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                
                <!-- início do card de busca -->
                <card-component titulo="Busca de modelos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do modelo">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>                   
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do modelo">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do modelo" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->


                <!-- início do card de listagem do modelo    -->
                <card-component titulo="Relação de modelos">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="modelos.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalmodeloVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalmodeloAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalmodeloRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key" 
                                        :class="l.active ? 'page-item active' : 'page-item'" 
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalModelo">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component> 
                <!-- fim do card de listagem de modelos -->
            </div>
        </div>


        <!-- início do modal de inclusão do modelo -->
        <modal-component id="modalModelo" titulo="Adicionar modelo">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do modelo">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="nomeModelo">
                    </input-container-component>
                    {{ nomeModelo }}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Numero de portas" id="novoNumeroDePortas" id-help="novoNumeroDePortasHelp" texto-ajuda="Informe o numero de portas">
                        <input type="number" class="form-control" id="novoNumeroDePortas" aria-describedby="novoNumeroDePortasHelp" placeholder="Numero de portas" v-model="numeroPortas">
                    </input-container-component>
                    {{ numeroPortas }}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Numero de lugares" id="novoNumeroDeLugares" id-help="novoNumeroDeLugares" texto-ajuda="Informe o numero de lugares">
                        <input type="text" class="form-control" id="novoNumeroDeLugares" aria-describedby="novoNumeroDeLugaresHelp" placeholder="Numero de lugares" v-model="numeroLugares">
                    </input-container-component>
                    {{ numeroLugares }}
                </div>

                <div class="form-group">
                    <label for="novoAirBag">Air-bag</label>
                    <select class="form-control" id="novoAirBag">
                        <option value="">Selecione</option>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="novoAbs">ABS</label>
                    <select class="form-control" id="novoAbs">
                        <option value="">Selecione</option>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>

                <!-- <div class="form-group">
                    <select-container-component text="ABS" >
                        <select-item
                            v-for="(option, index) in optionsAbs"
                            :key="index">
                        </select-item>
                    </select-container-component>
                </div> -->


                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{ arquivoImagem }}
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- fim do modal de inclusão do modelo -->

        <!-- início do modal de visualização do modelo -->
        <modal-component id="modalModeloVisualizar" titulo="Visualizar modelo">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- fim do modal de inclusão de modelo -->


        <!-- início do modal de remoção de modelo -->
        <modal-component id="modalmodeloRemover" titulo="Remover modelo">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da modelo">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!-- fim do modal de remoção de modelo -->

        <!-- início do modal de atualização de modelo -->
        <modal-component id="modalmodeloAtualizar" titulo="Atualizar modelo">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da modelo" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o nome da modelo">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da modelo" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- fim do modal de atualização de modelo -->
    </div>
</template>

<script>
import Paginate from './Paginate.vue'
    export default {
  components: { Paginate },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                nomeModelo: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                modelos: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            atualizar() {

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)

                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0])
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de modelo atualizado com sucesso!'

                        //limpar o campo de seleção de arquivos
                        atualizarImagem.value = ''
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmacao) {
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete')

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {                        
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })

            },
            pesquisar() {
                //console.log(this.busca)

                let filtro = ''

                for(let chave in this.busca) {

                    if(this.busca[chave]) {
                        //console.log(chave, this.busca[chave])
                        if(filtro != '') {
                            filtro += ";"
                        }
                    
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },
            paginacao(l) {
                if(l.url) {
                    //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                
                axios.get(url)
                    .then(response => {
                        this.modelos = response.data
                        //console.log(this.modelos)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                console.log(this.nomeModelo, this.arquivoImagem[0])

                let formData = new FormData();
                formData.append('nome', this.nomeModelo)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('numeroPortas', this.numeroPortas)
                formData.append('numeroLugares', this.numeroLugares)
                //adicionar campo airbag

                //adicionar campo ABS 
                

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
                        
                        console.log(response)
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                        //errors.response.data.message
                    })
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
