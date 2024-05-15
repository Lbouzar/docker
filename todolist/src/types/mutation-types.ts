import type { State } from './State'
export enum MutationTypes {
  SET_COUNTER = 'SET_COUNTER'
}

export type Mutations<S = State> = {
  [MutationTypes.SET_COUNTER](state: S, payload: number): void
}
