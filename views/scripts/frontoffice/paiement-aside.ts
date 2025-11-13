// ============================================================================
// ASIDE (RECAP) - Version avec base de données
// ============================================================================

import { CartItem, AsideHandle } from "./paiement-types";

export function initAside(
  recapSelector: string,
  cart: CartItem[],
  onCartUpdate: () => void
): AsideHandle {
  const container = document.querySelector(recapSelector) as HTMLElement;

  if (!container) {
    console.error("Container aside non trouvé:", recapSelector);
    throw new Error("Container aside non trouvé");
  }

  // Debug: afficher les données reçues
  console.log("Données cart reçues dans aside:", cart);

  function normalizeCartItem(item: any): CartItem {
    return {
      id: String(item.id || item.idProduit || ""),
      nom: String(item.nom || "Produit sans nom"),
      prix: Number(item.prix || 0),
      qty: Number(item.qty || item.quantiteProduit || 0),
      img: item.img || item.URL || "../../public/images/default.png",
    };
  }

  const normalizedCart: CartItem[] = cart.map(normalizeCartItem);
  console.log("Cart normalisé:", normalizedCart);

  async function updateQty(id: string, delta: number) {
    try {
      console.log("Mise à jour quantité:", id, delta);

      const formData = new FormData();
      formData.append("action", "updateQty");
      formData.append("idProduit", id);
      formData.append("delta", delta.toString());

      const response = await fetch("", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`Erreur HTTP: ${response.status}`);
      }

      const result = await response.json();
      console.log("Réponse updateQty:", result);

      if (result.success) {
        console.log("Quantité mise à jour - Rechargement");
        window.location.reload();
      } else {
        alert("Erreur: " + (result.error || "Erreur inconnue"));
      }
    } catch (error) {
      console.error("Erreur:", error);
      alert("Erreur réseau: " + (error as Error).message);
    }
  }

  async function removeItem(id: string) {
    try {
      if (!confirm("Supprimer ce produit du panier ?")) {
        return;
      }

      console.log("Suppression produit:", id);

      const formData = new FormData();
      formData.append("action", "removeItem");
      formData.append("idProduit", id);

      const response = await fetch("", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`Erreur HTTP: ${response.status}`);
      }

      const result = await response.json();
      console.log("Réponse removeItem:", result);

      if (result.success) {
        console.log("Produit supprimé - Rechargement");
        window.location.reload();
      } else {
        alert("Erreur: " + (result.error || "Erreur inconnue"));
      }
    } catch (error) {
      console.error("Erreur:", error);
      alert("Erreur réseau: " + (error as Error).message);
    }
  }

  function attachListeners() {
    // Boutons +
    container
      .querySelectorAll<HTMLButtonElement>("button.plus")
      .forEach((btn) => {
        btn.addEventListener("click", (ev) => {
          ev.preventDefault();
          const id = btn.getAttribute("data-id");
          if (id) {
            updateQty(id, 1);
          }
        });
      });

    // Boutons -
    container
      .querySelectorAll<HTMLButtonElement>("button.minus")
      .forEach((btn) => {
        btn.addEventListener("click", (ev) => {
          ev.preventDefault();
          const id = btn.getAttribute("data-id");
          if (id) {
            updateQty(id, -1);
          }
        });
      });

    // Boutons suppression
    container
      .querySelectorAll<HTMLButtonElement>("button.delete")
      .forEach((btn) => {
        btn.addEventListener("click", (ev) => {
          ev.preventDefault();
          const id = btn.getAttribute("data-id");
          if (id) {
            removeItem(id);
          }
        });
      });
  }

  function render() {
    console.log("Rendu du aside avec", normalizedCart.length, "produits");

    if (normalizedCart.length === 0) {
      container.innerHTML = '<div class="empty-cart">Panier vide</div>';
      return;
    }

    let html = "";
    normalizedCart.forEach((item) => {
      const total = item.prix * item.qty;
      html += `
        <div class="produit" data-id="${item.id}">
          <img src="${item.img}" alt="${item.nom}" />
          <div class="infos">
            <p class="titre">${item.nom}</p>
            <p class="prix">${total.toFixed(2)}€</p>
            <div class="gestQte">
              <div class="qte">
                <button class="minus" data-id="${item.id}">-</button>
                <span class="qty" data-id="${item.id}">${item.qty}</span>
                <button class="plus" data-id="${item.id}">+</button>
              </div>
              <button class="delete" data-id="${item.id}">
                <img src="../../public/images/bin.svg" alt="Supprimer">
              </button>
            </div>
          </div>
        </div>
      `;
    });

    container.innerHTML = html;
    attachListeners();
  }

  // Initial render
  render();

  return {
    update(newCart: CartItem[]) {
      console.log("Mise à jour aside avec nouveau panier:", newCart);
      const newNormalizedCart = newCart.map(normalizeCartItem);
      normalizedCart.splice(0, normalizedCart.length, ...newNormalizedCart);
      render();
      onCartUpdate();
    },
    getElement() {
      return container;
    },
  };
}
