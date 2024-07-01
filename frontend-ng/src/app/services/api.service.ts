import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private baseUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) { }

  getProducts(): Observable<any> {
    return this.http.get(`${this.baseUrl}/products`);
  }

  getProduct(id: number): Observable<any> {
    return this.http.get(`${this.baseUrl}/products/${id}`);
  }

  getCart(): Observable<any> {
    return this.http.get(`${this.baseUrl}/cart`);
  }

  addToCart(productId: number, amount: number): Observable<any> {
    return this.http.put(`${this.baseUrl}/products/${productId}/cart`, { amount });
  }

  removeFromCart(productId: number): Observable<any> {
    return this.http.delete(`${this.baseUrl}/products/${productId}/cart`);
  }
}
