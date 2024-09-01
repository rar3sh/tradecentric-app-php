import { describe, expect, test } from 'vitest';
import { Order } from "../Models/Order.ts";

describe('Order Model', () => {
    test('Test default properties', () => {
        let order = new Order();

        expect(order.id).toBe(undefined);
        expect(order.buyer_name).toBe(null);
        expect(order.order_number).toBe(null);
        expect(order.created_at).toBe(null);
        expect(order.total).toBe(0);
        expect(order.items).toEqual([]);
    });
});
