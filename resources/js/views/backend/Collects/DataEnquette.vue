<template>
    <v-layout>
      <!-- <v-flex md2></v-flex> -->
      <v-flex md12>
        <v-flex md12>
          <!--  -->
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  {{ titleComponent }} <v-spacer></v-spacer>
                  <v-tooltip bottom color="black">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                        <v-btn @click="dialog = false" text fab depressed>
                          <v-icon>close</v-icon>
                        </v-btn>
                      </span>
                    </template>
                    <span>Fermer</span>
                  </v-tooltip></v-card-title>
                <v-card-text>

                    <v-autocomplete label="Selectionnez le Genre" prepend-inner-icon="mdi-map"
                     :rules="[(v) => !!v || 'Ce champ est requis']" :items="genreList" dense
                     item-text="nom_genre" item-value="id" outlined v-model="svData.id_genre">
                 </v-autocomplete>                 

                  <v-autocomplete label="Selectionnez le Type de Violation" prepend-inner-icon="mdi-map"
                     :rules="[(v) => !!v || 'Ce champ est requis']" :items="violationList" dense
                     item-text="nom_violation" item-value="id" outlined v-model="svData.id_violation">
                  </v-autocomplete>

                  <v-autocomplete label="Selectionnez l'Ethni" prepend-inner-icon="mdi-map"
                     :rules="[(v) => !!v || 'Ce champ est requis']" :items="ethniList" dense
                     item-text="nom_ethni" item-value="id" outlined v-model="svData.id_ethni">
                 </v-autocomplete>

                 <v-autocomplete label="Selectionnez l'Auteur" prepend-inner-icon="mdi-map"
                     :rules="[(v) => !!v || 'Ce champ est requis']" :items="auteurList" dense
                     item-text="nom_auteur" item-value="id" outlined v-model="svData.id_auteur">
                 </v-autocomplete>                 

                 <v-autocomplete label="Selectionnez l'agent" prepend-inner-icon="mdi-map"
                   :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList"
                   item-text="noms_agent" item-value="id" dense outlined v-model="svData.refAgent"
                   chips clearable>
                 </v-autocomplete>


                </v-card-text>
                
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                  <v-btn color="  blue" dark :loading="loading" @click="validate">
                    {{ edit ? "Modifier" : "Ajouter" }}
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <br /><br />
          <!-- fin modal -->
  
          <!-- bande -->
          <v-layout>
            <v-flex md1>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn :loading="loading" fab @click="onPageChange">
                      <v-icon>autorenew</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Initialiser</span>
              </v-tooltip>
            </v-flex>
            <v-flex md6>
              <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
                v-model="query" @keyup="onPageChange" clearable></v-text-field>
            </v-flex>
  
            <v-flex md4></v-flex>
  
            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="showModal" fab color="  blue" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une opération</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
          <!-- bande -->
  
          <br />
          <v-card :loading="loading" :disabled="isloading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Genre</th>
                      <th class="text-left">Violation</th>
                      <th class="text-left">Ethni</th>
                      <th class="text-left">Auteur</th>
                      <th class="text-left">Agent</th>
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.nom_genre }}({{ item.code_genre }})</td>
                      <td>{{ item.nom_violation }}({{ item.code_violation }})</td>
                      <td>{{ item.nom_ethni }}({{ item.code_ethni }})</td>
                      <td>{{ item.nom_auteur }}({{ item.code_auteur }})</td>
                      <td>{{ item.noms_agent }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                      </td>
  
                      <td>
                        <v-tooltip v-if="userData.roles == 1" top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                            </span>
                          </template>
                          <span>Modifier</span>
                        </v-tooltip>
  
                        <!-- <v-tooltip top   color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="clearP(item.id)" fab small><v-icon color="  red">delete</v-icon></v-btn>
                            </span>
                          </template>
                          <span>Supprimer</span>
                        </v-tooltip> -->
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <hr />
  
              <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
                :total-visible="7"></v-pagination>
            </v-card-text>
          </v-card>
          <!-- component -->
          <!-- fin component -->
        </v-flex>
      </v-flex>
      <!-- <v-flex md2></v-flex> -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    components: {},
    data() {
      return {
        title: "Categorie component",
        header: "Crud operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false, 
        //'id','id_violation','id_ethni','id_genre','id_auteur','refAgent','author','refUser'
        svData: {
          id: "",
          id_violation:0,
          id_ethni:0,
          id_genre:0,
          id_auteur:0,
          refAgent:0,
          author:'',
          refUser:0
        },
        fetchData: null,
        violationList: [],
        ethniList: [],
        genreList: [],
        auteurList: [],
        agentList: [],
        titreModal: ""
      };
    },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout Collecte";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        this.titleComponent = "Ajout Collecte";
      }
      ,
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_all_data_enquete?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          this.svData.author =  this.userData.name;
          this.svData.refUser =  this.userData.id;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_data_enquete`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
  
              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_data_enquete/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification des donnees";
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_data_enquete/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
        fetchListViolation() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_violation2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.violationList = donnees;
                }
            );
        },
        fetchListEthni() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_ethni2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.ethniList = donnees;
                }
            );
        },
        fetchListAuteur() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_auteur2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.auteurList = donnees;
                }
            );
        },
        fetchListGenre() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_genre2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.genreList = donnees;
                }
            );
        },
        fetchListAgent() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
            ({ data }) => {
            var donnees = data.data;
            this.agentList = donnees;
            }
        );

        },
  
  
    },
    created() {       
      this.testTitle();
      this.onPageChange();


      this.fetchListViolation();      
      this.fetchListEthni();
      this.fetchListAuteur();
      this.fetchListGenre();
      this.fetchListAgent();
    },
  };
  </script>