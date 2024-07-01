import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})

export class CartComponent implements OnInit {
  cartItems: any[] = [];
  totalCost: number = 0;

  constructor(private apiService: ApiService) { }

  ngOnInit(): void {
    this.loadCart();
  }

  loadCart(): void {
    this.apiService.getCart().subscribe(data => {
      this.cartItems = data;
      this.calculateTotalCost();
    });
  }

  calculateTotalCost(): void {
    this.totalCost = this.cartItems.reduce((sum, item) => sum + item.product.price * item.amount, 0);
  }

  removeItem(productId: number): void {
    this.apiService.removeFromCart(productId).subscribe(() => {
      this.loadCart();
    });
  }

  updateAmount(productId: number, amount: number): void {
    this.apiService.addToCart(productId, amount).subscribe(() => {
      this.loadCart();
    });
  }
}
