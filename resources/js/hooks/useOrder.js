import { useForm } from "@inertiajs/react";

export function useOrder(orderItems) {
  const addOrderForm = useForm({
    order_items: orderItems,
  });

  const addOrder = () => {
    addOrderForm.post('/orders', {
      onSuccess: () => {
        //
      },
    });
  };

  return {
    addOrderForm,
    addOrder,
  };
}
