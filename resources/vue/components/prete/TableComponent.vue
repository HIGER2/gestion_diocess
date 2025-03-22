
<script setup>
import { computed, inject } from 'vue';
import DetailPreteComponent from './DetailPreteComponent.vue';
import EditPreteComponent from './EditPreteComponent.vue';
import PreteDeleteComponent from './PreteDeleteComponent.vue';

const { liste_Prete, dioceses } = defineProps([ 'liste_Prete', 'dioceses' ]);
function verifierRetraite(dateNaissance) {
    let message =""
    const dateActuelle = new Date();
    const naissance = new Date(dateNaissance);

    // Calculer l'âge
    const age = dateActuelle.getFullYear() - naissance.getFullYear();
    const moisDiff = dateActuelle.getMonth() - naissance.getMonth();
    const jourDiff = dateActuelle.getDate() - naissance.getDate();
    const ageFinal = moisDiff < 0 || (moisDiff === 0 && jourDiff < 0) ? age - 1 : age;

    // Calculer la date d'anniversaire des 65 ans
    const date65Ans = new Date(naissance);
    date65Ans.setFullYear(naissance.getFullYear() + 65);

    // Calculer la date deux semaines avant les 65 ans
    const deuxSemainesAvant65 = new Date(date65Ans);
    deuxSemainesAvant65.setDate(date65Ans.getDate() - 14);

    // Logique d'affichage
    if (ageFinal >= 65) {
        message = "Retraite atteinte !"

    } else if (dateActuelle >= deuxSemainesAvant65 && dateActuelle < date65Ans) {
        message = `2 semaines avant retraite !`
    } else {
        const tempsRestant = date65Ans - dateActuelle;
      const anneesRestantes = Math.floor(tempsRestant / (1000 * 60 * 60 * 24 * 365.25))
        message = `${anneesRestantes} an(s) restant(s)`
    }
    return message
}
const auth = computed(()=>inject('user'))

// Exemple d'utilisation
const commandes = [
  { id: 2123213, client: "douma douma", montant: "F135432.00" },
  { id: 2123214, client: "Jean Dupont", montant: "F123232.00" }
];

const imprimerLigne = (commande) => {
  const content = `
    <html>
      <head>
        <title>Impression Commande</title>
        <style>
          body { font-family: Arial, sans-serif; padding: 20px; }
          h2 { text-align: center; }
          .print-section { width: 100%; max-width: 400px; margin: auto; }
          p { font-size: 14px; line-height: 1.5; }
        </style>
      </head>
      <body>
        <div class="print-section">
          <h2>Commande #${commande.id}</h2>
          <p><strong>Client :</strong> ${commande.client}</p>
          <p><strong>Montant :</strong> ${commande.montant}</p>
        </div>

      </body>
    </html>
  `;

  const printWindow = window.open('', '', 'width=600,height=400');
  printWindow.document.write(content);
  printWindow.document.close();
};
</script>

<template>
    <table class="min-w-full bg-white  rounded-lg">
        <thead>
            <tr class="bg-custom text-gray-600 capitalize text-[11px] leading-normal">
                <th class="p-3 py-4 text-left">Nom</th>
                <th class="p-3 py-4 text-left">Prénoms</th>
                <th class="p-3 text-left">Matricule</th>
                <th class="p-3 text-left">Diocèse</th>
                <!-- <th class="p-3 text-left">Date de Naissance</th> -->
                <!-- <th class="p-3 text-left">Lieu de Naissance</th> -->
                <!-- <th class="p-3 text-left">Date Ordination Sacerdotale</th> -->
                <th class="p-3 text-left">Lieu Ordination</th>
                <!-- <th class="p-3 text-left">Diplôme Ecclésiastique</th> -->
                <!-- <th class="p-3 text-left">Diplôme Profane</th> -->
                <th class="p-3 text-left">Téléphone</th>
                <!-- <th class="p-3 text-left">Email</th> -->
                <th class="p-3 text-left">Date de rétraite</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-[12px] font-light ">
            <tr v-for="(item,index) in liste_Prete" :key="index" class=" border-b cursor-pointer hover:bg-zinc-50 ">
                <td class="p-3 py-4 ">{{ item?.nom }}</td>
                <td class="p-3 py-4 ">{{ item?.prenoms }}</td>
                <td class="p-3 py-4 ">{{ item?.matricule }}</td>
                <td class="p-3 py-4 ">{{ item?.diocess?.diocese }}</td>
                <!-- <td class="p-3 py-4 ">{{ formatDate(item.date_naissance) }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ item.lieu_naissance }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ formatDate(item.date_ordination_sacerdotale) }}</td> -->
                <td class="p-3 py-4 ">{{ item.lieu_ordination_sacerdotale }}</td>
                <!-- <td class="p-3 py-4 ">{{ item.diplome_etude_ecclesiastique }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ item.diplome_etude_profane }}</td> -->
                <td class="p-3 py-4 ">{{ item.numero_telephone }}</td>
                <!-- <td class="p-3 py-4 ">{{ item.adresse_electronique }}</td> -->
                <td class="p-3 py-4 ">{{verifierRetraite(item.date_naissance)  }}
                </td>
                <td class="p-3 py-4  flex gap-2 text-zinc-900">
                    <!-- <button @click="imprimerLigne(commande)">🖨 Imprimer</button> -->
                    <EditPreteComponent :item="item" :dioceses="dioceses"/>
                    <DetailPreteComponent :item="item"  />
                    <template v-if="auth.role !=='modérateur'">
                    <PreteDeleteComponent :item="item"/>
                    </template>
                </td>
            </tr>
        </tbody>
    </table>
</template>


