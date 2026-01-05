import { useForm } from "@inertiajs/react";

export function useCartItem(productId, quantity) {
  const addCartItemForm = useForm({
    product_id: productId,
    quantity: quantity,
  });

  const updateCartItemForm = useForm({
    quantity: quantity,
  });

  const destroyCartItemForm = useForm({});

  const addCartItem = () => {
    addCartItemForm.post('/cart-items', {
      preserveScroll: true,
      onSuccess: () => {
        //
      },
    });
  };

  const updateCartItem = (cartItemId) => {
    updateCartItemForm.patch('/cart-items/' + cartItemId, {
      preserveScroll: true,
      onSuccess: () => {
        //
      },
    });
  };

  const destroyCartItem = (cartItemId) => {
    destroyCartItemForm.delete('/cart-items/' + cartItemId, {
      preserveScroll: true,
      onSuccess: () => {
        //
      },
    });
  };

  return {
    addCartItemForm,
    addCartItem,
    updateCartItemForm,
    updateCartItem,
    destroyCartItemForm,
    destroyCartItem,
  };
}
